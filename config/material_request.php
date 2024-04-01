<?php
session_start();
include "db.php";

if (isset($_POST['submit'])) {
    if (isset($_POST['material']) && isset($_POST['quantity'])) {
        $date = $_POST['date'];
        $message = $_POST['text'];
        $branch_id = $_POST['branch'];
        $ticket_number = $_POST['ticketdate'];
        $confirm = "";
        $ship = "";
        $received = "";
        $stat = "Pending Request";

        // Prepare and bind SQL statement for inserting into requested_materials table
        $stmt = $con->prepare("INSERT INTO requested_materials (material, quantity, Request_date, Confirm_date, Shipping_date, Received_date, ticket_number, Status,message,product_id) VALUES (?,?, ?, ?, ?, ?, ?, ?,?, ?)");

        if ($stmt) {
            foreach ($_POST['material'] as $key => $material) {
                $quantity = isset($_POST['quantity'][$key]) ? $_POST['quantity'][$key] : 0;
                $productID = $_POST['material_id'][$key];

                // Bind parameters
                $stmt->bind_param("ssssssssss", $material, $quantity, $date, $confirm, $ship, $received, $ticket_number, $stat,$message,$productID);

                // Execute the statement
                if (!$stmt->execute()) {
                    // Output error message if insertion fails
                    $_SESSION['msg'] = "Error: " . $stmt->error;
                    break; // Exit loop if an error occurs
                }
            }
            // Close the prepared statement after use
            $stmt->close();
        } else {
            $_SESSION['msg'] = "Error preparing statement: " . $con->error;
        }

        // Insert ticket number into login table's branch_id column for the current user
        $insert_stmt = $con->prepare("INSERT INTO tbl_request_person (Branch_id, User_id, User_branch) VALUES (?, ?, ?)");

        if ($insert_stmt) {
            $insert_stmt->bind_param("sss", $ticket_number, $_SESSION['user_id'], $branch_id);
            if (!$insert_stmt->execute()) {
                $_SESSION['msg'] = "Error inserting ticket number: " . $insert_stmt->error;
            }
            // Close the prepared statement after use
            $insert_stmt->close();
        } else {
            $_SESSION['msg'] = "Error preparing statement: " . $con->error;
        }

        // Set session message for success if no errors occurred
        if (!isset($_SESSION['msg'])) {
            $_SESSION['msg'] = "Materials requested successfully.";
        }
    } else {
        // Set session message for error if no materials were selected
        $_SESSION['msg'] = "Error: Please select at least one material.";
    }

    // Redirect back to the form page
    header("Location: ../request.php");
    exit();
}
?>