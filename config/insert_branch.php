<?php
// Include database connection file
include("db.php");

// Check if the form is submitted
if(isset($_POST['added'])) {
    // Retrieve form data
    $location = $_POST['location'];
    $ownerName = $_POST['name'];
    $contactNumber = $_POST['num'];

    // SQL query to insert data into tbl_branch table
    $insertQuery = "INSERT INTO tbl_branch (location, name, number) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertQuery);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, 'sss', $location, $ownerName, $contactNumber);
    $result = mysqli_stmt_execute($stmt);

    // Check if the insertion was successful
    if ($result) {
        echo "New branch added successfully.";
    } else {
        echo "Error adding branch: " . mysqli_error($con);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
// Redirect back to the room.php page
header("Location: ../branch.php");
exit();
?>
