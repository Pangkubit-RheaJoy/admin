<?php
session_start();
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM `login` WHERE `UserId` = '$id'";
    
    if (mysqli_query($con, $deleteQuery)) {
        $_SESSION['msgdelete'] = "Staff Deleted Successfully";
    } else {
        $_SESSION['msgdelete'] = "Error: " . mysqli_error($con);
    }
} else {
    $_SESSION['msgdelete'] = "Invalid Request";
}

// Redirect back to the room.php page
header("Location: ../staff.php");
exit();
?>
