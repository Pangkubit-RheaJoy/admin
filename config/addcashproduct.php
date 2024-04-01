<?php
include("db.php");

if(isset($_POST['added'])) {
    // Process form data
    $productName = $_POST['P_name'];
    $branch = $_POST['branch_id'];
    $S_Price = $_POST['small_price'];
    $M_Price = $_POST['medium_price'];
    $L_Price = $_POST['large_price'];

    // File upload handling
    $targetDirectory = "../uploads/"; // Directory where the uploaded files will be stored
    $img = $_FILES['file']['name']; // File name of the uploaded image
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]); // Path to the uploaded image on the server

    // Move the uploaded file to the target directory
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Insert drink product data into database
        $query = "INSERT INTO tbl_cashproduct (productName, img, S_Price, M_Price, L_Price, branch_id) 
                  VALUES ('$productName', '$img', '$S_Price', '$M_Price', '$L_Price', $branch)";

        // Execute the query
        if(mysqli_query($con, $query)) {
            // Product added successfully, redirect to the display page
            header("Location:../product.php");
            exit(); // Ensure no further code execution after redirection
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
