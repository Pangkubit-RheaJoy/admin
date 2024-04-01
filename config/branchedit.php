<?php
include("db.php");

if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $loc = $_POST['loc'];
    $name = $_POST['name'];
    $num = $_POST['num'];

    // SQL query to update data in tbl_product table
    $updateQuery = "UPDATE tbl_branch SET location=?, name=?, number=? WHERE branch_id=?";
    
    // Prepare the SQL statement
    $stmt = mysqli_prepare($con, $updateQuery);

    // Check for errors in preparing the statement
    if ($stmt === false) {
        die("Error: " . mysqli_error($con));
    }

    // Bind parameters and execute the statement
    $result = mysqli_stmt_bind_param($stmt, 'sssi', $loc, $name, $num, $id);
    if ($result === false) {
        die("Error binding parameters: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_execute($stmt);
    if ($result === false) {
        die("Error executing statement: " . mysqli_stmt_error($stmt));
    }

    echo "Record updated successfully.";

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
// Redirect back to the room.php page
header("Location: ../branch.php");
exit();
?>
