<?php
session_start();
include "db.php";

if(isset($_POST['added'])) {
    // Retrieve form data
    $type = $_POST['type_P'];
    $productName = $_POST['product_name'];
    $quantity = $_POST['P_quantity'];
    $status = $_POST['Status'];
    // You might need to handle file upload for the image separately

    // Insert data into the database
    $query = "INSERT INTO tbl_request (R_name, R_type, R_quantity, R_status) VALUES ('$productName', '$type', '$quantity', '$status')";

    // Execute query
    $result = mysqli_query($con, $query);

    if($result) {
        echo "Product requested successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
// Redirect back to the room.php page
header("Location: ../inventory.php");
exit();
?>