<?php
include("db.php");

if(isset($_POST['edit'])) {
    // Process form data
    $id = $_POST['id']; // Assuming you have an input field for the product ID
    $productName = $_POST['P_name'];
    $productType = $_POST['type'];
    
    if($productType == 'Drink') {
        $small = $_POST['small_price'];
        $medium = $_POST['medium_price'];
        $large = $_POST['large_price'];
        
        // Update drink product data in the database
        $query = "UPDATE tbl_menu 
                  SET PN = ?, S_price = ?, M_price = ?, L_price = ?
                  WHERE menu_id = ?";
        
        // Prepare the SQL statement
        $stmt = mysqli_prepare($con, $query);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'siiii', $productName, $small, $medium, $large, $id);
        
        // Execute the query
        if(mysqli_stmt_execute($stmt)) {
            echo "Product updated successfully.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $price = $_POST['food_price'];
        
        // Update food product data in the database
        $query = "UPDATE tbl_menu 
                  SET PN = ?, price = ?
                  WHERE menu_id = ?";
        
        // Prepare the SQL statement
        $stmt = mysqli_prepare($con, $query);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sii', $productName, $price, $id);
        
        // Execute the query
        if(mysqli_stmt_execute($stmt)) {
            echo "Product updated successfully.";
        } else {
            echo "Error: " . mysqli_error($con);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Error: Edit button not clicked.";
}
?>
