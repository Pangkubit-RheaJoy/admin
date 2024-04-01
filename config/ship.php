<?php
session_start();
include "db.php";

if(isset($_POST['ship'])) {
    $requestID = $_POST['id'];
    $currentDate = date('Y-m-d H:i:s'); // Get the current date and time

    // Begin a transaction
    mysqli_begin_transaction($con);

    // Update the database for requested_materials table
    $updateQuery = "UPDATE requested_materials SET Status = 'Product Shipped', Status_id = 2, Shipping_date = ? WHERE ticket_number = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'si', $currentDate, $requestID);

    if (mysqli_stmt_execute($stmt)) {
        // Update successful

        $updateProductQuery = "UPDATE tbl_products AS tbl_products 
                               INNER JOIN requested_materials AS requested_materials ON tbl_products.ProductID = requested_materials.product_id
                               SET tbl_products.Product_quantity = tbl_products.Product_quantity - requested_materials.quantity
                               WHERE requested_materials.ticket_number = ?";
        $stmtProduct = mysqli_prepare($con, $updateProductQuery);
        mysqli_stmt_bind_param($stmtProduct, 'i', $requestID); // Bind parameters
        $updateProductResult = mysqli_stmt_execute($stmtProduct);

        if ($updateProductResult) {
            // Commit the transaction if both updates are successful
            mysqli_commit($con);
            $_SESSION['request_updated'] = "Request updated successfully.";
        } else {
            // Rollback the transaction if any update fails
            mysqli_rollback($con);
            $_SESSION['request_error'] = "Error updating request: " . mysqli_error($con);
        }

        // Close prepared statements
        mysqli_stmt_close($stmtProduct);
    } else {
        $_SESSION['request_error'] = "Error updating request: " . mysqli_error($con);
    }

    // Close the prepared statement for requested_materials
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['request_error'] = "Confirm request not set.";
}

// Check if the Branch_id is 0
if ($_SESSION['Branch_id'] == 0) {
    header("Location: ../material.php");
} else {
    // Redirect back to the request.php page
    header("Location: ../request.php");
}
exit();
?>
