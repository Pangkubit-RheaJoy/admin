<?php
session_start();
include "db.php";

if(isset($_POST['cancelled'])) {
    $requestID = $_POST['id'];

    // Update the database
    $updateQuery = "UPDATE requested_materials SET Status = 'Cancelled', Status_id = 5 WHERE ticket_number = ?";
    $stmt = mysqli_prepare($con, $updateQuery);

    // Bind parameters to the statement
    mysqli_stmt_bind_param($stmt, 'i', $requestID); // 'i' indicates integer type for request_id

    if (mysqli_stmt_execute($stmt)) {
       $_SESSION['request_updated'] = "Request updated successfully.";
    } else {
        $_SESSION['request_error'] = "Error updating request: " . mysqli_error($con);
    }
    mysqli_stmt_close($stmt); // Close the prepared statement
} else {
    $_SESSION['request_error'] = "Cancelled request not set.";
}

// Check if the Branch_id is 0
if ($_SESSION['Branch_id'] == 0) {
    header("Location: ../material.php");
} else {
    // Redirect back to the request.php page
    header("Location: ../request.php");
}
exit();
?>
