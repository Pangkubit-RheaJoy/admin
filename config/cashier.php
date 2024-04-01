<?php
include('db.php');

// Retrieve data sent from JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Insert cart items into the database
foreach ($data['cartItems'] as $item) {
    $productName = $item['productName'];
    $productQuantity = $item['productQuantity'];
    $productPrice = $item['productPrice'];
    
    // Perform your database insert operation here
     mysqli_query($conn, "INSERT INTO tbl_receipt(P_name, P_Quantity, P_price) VALUES ('$productName', '$productQuantity', '$productPrice')");
}

// Insert tendered amount and total amount into the database
$tenderedAmount = $data['tenderedAmount'];
$totalAmount = $data['totalAmount'];

// Perform your database insert operation for tendered amount and total amount here
 mysqli_query($conn, "INSERT INTO tbl_receipt (tendered, total) VALUES ('$tenderedAmount', '$totalAmount')");

// Send a response back to JavaScript (optional)
echo "Data inserted successfully!";
?>
