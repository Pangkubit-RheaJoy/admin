<?php
session_start();
include('db.php');

if(isset($_GET['cancel_id'])) {
    $id = $_GET['cancel_id'];

    // Delete query
    $deleteQuery = "DELETE FROM tbl_request WHERE request_id = ?";

    // Prepare statement
    $stmt = mysqli_prepare($con, $deleteQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Execute statement
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['product_deleted'] = "Request cancelled successfully.";
    } else {
        echo "Error: " . $deleteQuery . "<br>" . mysqli_error($con);
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Redirect back to the room.php page
header("Location: ../inventory.php");
exit();
?>
