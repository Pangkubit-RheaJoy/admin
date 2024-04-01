<?php
// Start the session
session_start();

// Establish database connection (assuming you have already included the necessary files)
include('db.php');

// Check if the form is submitted
if(isset($_POST['added'])) {
    // Retrieve form data
    $productName = mysqli_real_escape_string($con, $_POST['P_name']); // Prevent SQL injection
    $productQuantity = mysqli_real_escape_string($con, $_POST['P_quantity']); // Prevent SQL injection
    $productUnit = mysqli_real_escape_string($con, $_POST['P_unit']); // Prevent SQL injection

    
  
        // Insert data into database
        $insertQuery = "INSERT INTO tbl_products (Product_name, Product_quantity,Product_unit) 
                        VALUES ('$productName', '$productQuantity',' $productUnit')";
        if(mysqli_query($con, $insertQuery)) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }


// Redirect back to the room.php page
header("Location: ../material.php");
exit();
?>
