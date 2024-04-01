

<?php
include("db.php");

if(isset($_POST['added'])) {
    // Process form data
    $productName = $_POST['P_name'];
    $productType = $_POST['P_size'];
  

    // File upload handling
    $targetDirectory = "../uploads/"; // Directory where the uploaded files will be stored
    $img = $_FILES['file']['name']; // File name of the uploaded image
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]); // Path to the uploaded image on the server

    // Move the uploaded file to the target directory
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // File uploaded successfully, proceed with database insertion
        if($productType == 'Drink') {
            $small = $_POST['small_price'];
            $medium = $_POST['medium_price'];
            $large = $_POST['large_price'];
            
            // Insert drink product data into database
            $query = "INSERT INTO tbl_menu (PN,S_price,M_price,L_price, foodtype, img) 
            VALUES ('$productName','$small','$medium','$large', '$productType','$img')";
        } else {
            $price = $_POST['food_price'];
            // Insert food product data into database
            $query = "INSERT INTO tbl_menu (PN, img, foodtype, price) 
                      VALUES ('$productName', '$img', '$productType', '$price')";
        }

        // Execute the query
        if(mysqli_query($con, $query)) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Error uploading file.";
    }
}

?>



