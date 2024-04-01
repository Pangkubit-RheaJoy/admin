<?php
session_start();
include('db.php');

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $productName = $_POST['P_name'];
    

    if ($type == 'Drink') {
        $S_quantity = $_POST['S_quantity'];
        $S_price = $_POST['S_price'];
        $M_quantity = $_POST['M_quantity'];
        $M_price = $_POST['M_price'];
        $L_quantity = $_POST['L_quantity'];
        $L_price = $_POST['L_price'];

        $sql = "UPDATE tbl_cashproduct SET productName = ?, 
                S_Quantity = ?, S_Price = ?, 
                M_Quantity = ?, M_Price = ?, 
                L_Quantity = ?, L_Price = ? 
                WHERE id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'siiiiiii', $productName, $S_quantity, $S_price, $M_quantity, $M_price, $L_quantity, $L_price, $id);
    } else {
        // Update food product data in the database
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        // Update or insert food product data into database
        $sql = "UPDATE tbl_cashproduct SET productName = ?, price = ?, quantity = ?
                WHERE id = ?";

        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 'sdii', $productName, $price, $quantity, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['product_updated'] = "Product updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Redirect back to the product.php page
header("Location: ../product.php");
exit();
?>
