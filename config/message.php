<?php
session_start();
include "db.php";

if (isset($_POST['cancel'])) {
    // Get data from roombook table, ordered by ID
    $query = "SELECT * FROM roombook WHERE stat = 'pending' ORDER BY id LIMIT 1";
    $result = mysqli_query($con, $query);

    // Fetch the first row (assuming it's ordered by ID)
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Insert data into cancel_tbl regardless of availability
        $insertQuery = "INSERT INTO cancel_tbl (FName, mname, LName, suffix, Email, Phone, TRoom, Bed, NRoom, cin, cout, stat, Mess)
                        VALUES ('{$row['FName']}', '{$row['mname']}', '{$row['LName']}', '{$row['suffix']}', '{$row['Email']}', '{$row['Cp']}', '{$row['TRoom']}', '{$row['Bed']}', '{$row['NRoom']}', '{$row['cin']}', '{$row['cout']}', 'cancelled', '{$row['decline_reason']}')";
        mysqli_query($con, $insertQuery);

        // Delete data from roombook using the specific ID
        $deleteQuery = "DELETE FROM roombook WHERE id = '{$row['id']}'";
        mysqli_query($con, $deleteQuery);

        // Set cancellation message session
        $_SESSION['cancellation_message'] = 'The booking was cancelled successfully';
    } else {
        // Set error message session if no pending booking found
        $_SESSION['error_message'] = 'No pending booking found';
    }

    // Redirect to the same page or another page as needed
    header("Location: ../pendingbooking.php");
    exit();
}
?>
