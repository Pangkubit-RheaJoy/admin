<?php
session_start();
include "db.php";

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM `tbl_menu` WHERE `menu_id` = '$id'";
    
    if (mysqli_query($con, $deleteQuery)) {
        $_SESSION['msgdelete'] = "Product Deleted Successfully";
    } else {
        $_SESSION['msgdelete'] = "Error: " . mysqli_error($con);
    }
} else {
    $_SESSION['msgdelete'] = "Invalid Request";
}

// Redirect back to the room.php page
header("Location: ../menu.php");
exit();
?>
