<?php
session_start();
include "db.php";

// Check if user is already logged in
if(isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
    // Redirect to product page
    header("location: ../product.php");
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM login WHERE UserName=? AND Pass=?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ss', $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $_SESSION["user_id"] = $row["UserId"];
        $_SESSION['Branch_id'] = $row["branch_id"];
        $user_id = $row['UserId'];
        $branch_id = $row["branch_id"];
        $NameOfUser = $row['FN'] . ' ' . $row['LN'];
        $_SESSION['NameOfUser'] = $row['FN'] . ' ' . $row['LN'];
        $Role = $row['position_value'];

        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = $Role;
        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'NameOfUser' => $NameOfUser,
            'Branch' =>  $branch_id,
        ];

    // Check if the Branch_id is 0
if ($_SESSION['Branch_id'] == 0) {
    header("Location: ../product.php");
} else {
    // Redirect back to the request.php page
    header("Location: ../cashier.php");
}
exit();
      
    }
} else {
    $_SESSION['message-ok'] = 'Invalid email or password';
    header('Location: ../login.php');
    exit();
}

$stmt->close();
$con->close();
?>
