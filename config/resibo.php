98% of storage used … If you run out, you can't create, edit, and upload files. Get 100 GB of storage for ₱89.00 ₱22.25/month for 3 months.
<?php
include('db.php'); // Assuming this file includes your database connection

// Retrieve data from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);

// Extract cart data and other details
$cart = $data['cart'];
$tenderedAmount = $data['tenderedAmount'];
$totalAmount = $data['totalAmount'];
$changeAmount = $data['changeAmount']; // Include the change amount
$branchId = $data['branch_id']; // Include the branch ID
$orderNo = $data['orderNo']; // Include the order number
$totalMaterial = $data['Material']; // Include the total material

// Insert each cart item into the database
foreach ($cart as $item) {
    $productName = $item['productName'];
    $productSize = $item['productSize']; // Include product size
    $productQuantity = $item['productQuantity'];
    $productPrice = $item['productPrice'];

    // Perform SQL insert operation
    $sql_insert = "INSERT INTO tbl_sales (P_name, product_size, Price, Quantity, Total, Changed, Branch_id, Order_No) 
                   VALUES ('$productName', '$productSize', '$productPrice', '$productQuantity', '$totalAmount','$changeAmount', '$branchId','$orderNo')";

    // Execute SQL query for insertion
    if ($con->query($sql_insert) === TRUE) {
        echo "Record inserted successfully.";
    } else {
        echo "Error inserting record: " . $con->error;
    }

// Update requested_materials table by subtracting productQuantity for multiple materials
$sql_update = "UPDATE requested_materials 
               SET quantity = CASE 
                                WHEN material = 'Cups' THEN quantity - $totalMaterial
                                WHEN material = 'Straw' THEN quantity - $totalMaterial
                                WHEN material = '$productName' THEN quantity - $totalMaterial
                                ELSE quantity
                             END
               WHERE (material = 'Cups' OR material = 'Straw' OR material = '$productName') 
               ";



// Execute the update query
if ($con->query($sql_update) === TRUE) {
echo "Requested materials updated successfully.";
} else {
// Log or display the error message
echo "Error updating requested materials: " . $con->error;
// Print out the generated SQL query for debugging
echo "SQL Query: " . $sql_update;
}
}

// Close database connection
$con->close();
?>