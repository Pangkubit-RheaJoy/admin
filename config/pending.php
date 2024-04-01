<?php
session_start();
include "db.php";

if (isset($_POST['confirm'])) {
    // Get data from roombook table, ordered by ID
    $query = "SELECT * FROM roombook WHERE stat = 'pending' ORDER BY id";
    $result = mysqli_query($con, $query);

    // Fetch the first row (assuming it's ordered by ID)
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Check availability before inserting into app_tbl
        $availabilityCheckQuery = "SELECT no FROM room WHERE type = '{$row['TRoom']}' AND bedding = '{$row['Bed']}'";
        $availabilityResult = mysqli_query($con, $availabilityCheckQuery);
        $availabilityRow = mysqli_fetch_assoc($availabilityResult);

        if ($availabilityRow['no'] > 0) {
            // Insert data into app_tbl
            $insertQuery = "INSERT INTO app_tbl (FName, mname, LName, suffix, Email, Phone, TRoom, Bed, NRoom,cin, cout, stat)
                            VALUES ('{$row['FName']}', '{$row['mname']}', '{$row['LName']}', '{$row['suffix']}', '{$row['Email']}', '{$row['Cp']}', '{$row['TRoom']}', '{$row['Bed']}', '{$row['NRoom']}','{$row['cin']}', '{$row['cout']}', 'approved')";
            mysqli_query($con, $insertQuery);

            // Update data in room table
            $updateQuery = "UPDATE room SET no = no - {$row['NRoom']} WHERE type = '{$row['TRoom']}' AND bedding = '{$row['Bed']}'";
            mysqli_query($con, $updateQuery);

            // Delete data from roombook using the specific ID
            $deleteQuery = "DELETE FROM roombook WHERE id = '{$row['id']}'";
            mysqli_query($con, $deleteQuery);

            // Set approval message session
            $_SESSION['approval_message'] = 'Booking approved successfully';
        } else {
            // Set approval message session for no availability
            $_SESSION['approval_message'] = 'No availability to approve the booking';
        }
    } else {
        // Set approval message session for no pending bookings
        $_SESSION['approval_message'] = 'No pending bookings to approve';
    }

    // Redirect to the same page or another page as needed
    header("Location: ../pendingbooking.php");
    exit();
}
?>
<!-- ... (Your existing HTML and JavaScript code) ... -->
