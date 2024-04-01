<?php
    include('config/db.php');

    // Fetch order details from database
    if(isset($_GET['Order_No'])) {
        $orderNumber = $_GET['Order_No'];
        $query = "SELECT * FROM tbl_sales WHERE Order_No = '$orderNumber'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Receipt</title>
   
</head>
<body>
    <div class="container">
        <h1 class="text-center">Receipt</h1>
        <div class="info mb-4">
            <p><strong>Order Number:</strong> <?php echo $orderNumber; ?></p>
            <p><strong>Date:</strong> <?php echo date('Y-m-d'); ?></p>
        </div>
        <div class="items">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['P_name']; ?></td>
                            <td><?php echo $row['product_size']; ?></td>
                            <td><?php echo $row['Quantity']; ?></td>
                            <td>₱<?php echo $row['Price']; ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="total">
            <?php
                // Calculate and display total and change amount
                $totalAmount = 0;
                $changeAmount = 0;
                mysqli_data_seek($result, 0); // Reset result pointer
                while ($row = mysqli_fetch_assoc($result)) {
                    $totalAmount += $row['Price'];
                    $changeAmount += $row['Changed'];
                }
            ?>
            <p><strong>Total:</strong> ₱ <?php echo $totalAmount; ?></p>
            <p><strong>Change Amount:</strong> ₱<?php echo $changeAmount; ?></p>
        </div>
    </div>

    <div class="text-center mt-3">
        <!-- Add a print button -->
        <button class="btn btn-primary" onclick="printReceipt()">Print Receipt</button>
        <a class="btn btn-primary" href="cashier.php">No Receipt</a>
    </div>
   
    <script>
        function printReceipt() {
            // Hide all elements except the receipt
            var body = document.body.innerHTML;
            var receipt = document.querySelector('.container').innerHTML;
            document.body.innerHTML = receipt;
            // Print the receipt
            window.print();
            // Restore the body content
            document.body.innerHTML = body;
        }
    </script>
</body>
</html>
<?php
        } else {
            echo "<p>No order found with Order Number: " . $orderNumber . "</p>";
        }
    } else {
        echo "<p>No order number provided.</p>";
    }
?>
