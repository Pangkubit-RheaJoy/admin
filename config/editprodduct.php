<?php
session_start();
include('db.php');

if (isset($_POST['edit'])) {
    $id = $_POST['id'];

    $productName = mysqli_real_escape_string($con, $_POST['P_name']);
    $productQuantity = mysqli_real_escape_string($con, $_POST['P_quantity']);
  

    // Update data in database without changing image
    $updateQuery = "UPDATE tbl_products 
                    SET Product_name = ?, 
                        Product_quantity = ?  
                    WHERE ProductID = ?";

    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ssi', $productName, $productQuantity, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['product_updated'] = "Product updated successfully.";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Redirect back to the product.php page
header("Location: ../material.php");
exit();
?>
