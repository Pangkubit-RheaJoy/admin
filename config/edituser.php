<?php
session_start();
include "db.php";

if (isset($_POST['edit'])) {
    $id = $_POST['id'];

    $contact = mysqli_real_escape_string($con, $_POST['editContact']);
    $position = mysqli_real_escape_string($con, $_POST['editPosition']);
    $employeeNo = mysqli_real_escape_string($con, $_POST['editEmployeeNo']);
    $email = mysqli_real_escape_string($con, $_POST['editEmail']);
    
    // Check if a new password is provided
    if (!empty($_POST['editPassword'])) {
        // If a new password is provided, use it as is
        $password = $_POST['editPassword'];
        $updateQuery = "UPDATE `login` SET `Cp`=?, `position`=?, `Employno`=?, `UserName`=?, `Pass`=? WHERE `UserId`=?";
    } else {
        // If no new password is provided, keep the existing password
        $updateQuery = "UPDATE `login` SET `Cp`=?, `position`=?, `Employno`=?, `UserName`=? WHERE `UserId`=?";
    }

    // Perform the update using prepared statement
    $stmt = mysqli_prepare($con, $updateQuery);

    if ($stmt) {
        // Check if a new password is provided before binding parameters
        if (!empty($_POST['editPassword'])) {
            // Bind parameters with password
            mysqli_stmt_bind_param($stmt, 'sssssi',  $contact, $position, $employeeNo, $email, $password, $id);
        } else {
            // Bind parameters without password
            mysqli_stmt_bind_param($stmt, 'ssssi',  $contact, $position, $employeeNo, $email, $id);
        }

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['msgedit'] = "User Updated Successfully";
        } else {
            $_SESSION['msgedit'] = "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['msgedit'] = "Error preparing the statement";
    }
}

// Redirect back to the room.php page
header("Location: ../staff.php");
exit();
?>