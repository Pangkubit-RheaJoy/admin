<?php
// Establish database connection (assuming you have already included the necessary files)
include('db.php');

// Check if the form is submitted
if(isset($_POST['add'])) {
    // Retrieve form data
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quan'];
    $productPrice = $_POST['product_price'];
    $id= $_POST['product_id'];
    
   
                    // Insert data into database
                    $insertQuery = "INSERT INTO tbl_receipt (P_name, P_Quantity,P_price) 
                                    VALUES ('$productName', '$productQuantity', '$productPrice')";
                    if(mysqli_query($con, $insertQuery)) {
                        $_SESSION['product_added'] =  "Product added successfully.";
                    } else {
                        echo "Error: " . $insertQuery . "<br>" . mysqli_error($con);
                    }
                } else {
        echo "File is not an image.";
    }


// Redirect back to the room.php page
header("Location: ../cashier2.php");
exit();
?>
