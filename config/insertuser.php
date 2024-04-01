<?php
session_start();
include "db.php";

if (isset($_POST['add'])) {
    // Validate and sanitize inputs
    $ln = mysqli_real_escape_string($con, $_POST['ln']);
    $fn = mysqli_real_escape_string($con, $_POST['fn']);
    $mn = mysqli_real_escape_string($con, $_POST['mn']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $employee_no = mysqli_real_escape_string($con, $_POST['employee_no']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check for empty fields
    if (empty($ln) || empty($fn) || empty($contact) || empty($position) || empty($employee_no) || empty($email) || empty($password)) {
        $_SESSION['msgemployee'] = "Please fill in all fields";
        header("Location: ../staff.php");
        exit();
    }

   
    // Determine position value
    switch($position) {
        case "Cashier":
            $position_value = "2";
            break;
        case "Staff":
            $position_value = "3";
            break;
        default:
            $position_value = ""; // Default value
    }

    // Prepare and execute the SQL statement using prepared statements
    $insertQuery = "INSERT INTO `login` (`LN`, `FN`, `MN`, `Cp`, `position`, `position_value`, `Employno`, `UserName`, `Pass`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssssssss", $ln, $fn, $mn, $contact, $position, $position_value, $employee_no, $email, $password);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msgemployee'] = "New Employee Added";
    } else {
        $_SESSION['msgemployee'] = "Error: " . mysqli_stmt_error($stmt);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Redirect back to the staff.php page
header("Location: ../staff.php");
exit();
?>
