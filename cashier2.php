<?php
// Assuming you have a database connection established already
include('config/db.php');
include('include/navbar.php');

?>

<style>
 .card{
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);"
 } 
 .bg-gray{
    background-color:lightgray;
 }
</style>
<body>
<div id="page-wrapper">
    <div id="page-inner">

    <div class="row mt-5">;

        <div class="col-md-6">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="collapse navbar-collapse" id="navbarNav">                   
                </div>
            </nav>
            <?php
include('config/db.php');

// Fetch products from the database
$query = "SELECT * FROM tbl_cashproduct";
$result = mysqli_query($con, $query);

if(mysqli_num_rows($result) > 0) {
    // Counter to keep track of cards in a row
    $cardCount = 0;
   
    echo '<div class="row mt-5">';
    while($row = mysqli_fetch_assoc($result)) {
        $img= $row['img'];
        if ($cardCount % 3 == 0 && $cardCount > 0) {
           
            echo '</div><div class="row mt-3">';
        }
        // Display each product in a card
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<img src="uploads/'.$img.'" class="card-img-top">';
        echo '<p class="card-text">Price: '.$row['Price'].'</p>';
        echo '<form method="POST" action="config/receipt2.php" enctype="multipart/form-data">';
        echo '<input type="hidden" name="product_id" value="'.$row['id'].'">';
        echo '<input type="hidden" name="product_name" value="'.$row['productName'].'">';
        echo '<input type="hidden" name="product_price" value="'.$row['Price'].'">';
        echo '<input type="hidden" name="product_quan" value="'.$row['Quantity'].'">';
        echo '<button type="submit" class="btn btn-primary add-to-cart-btn" name="add">Add</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        $cardCount++;
    }
    echo '</div>'; // Close the last row
} else {
    echo "No products found";
}
?>
</div>

<!-- Right Side: Cart Items -->
<div class="col-md-6">
    <div class="card cartsize bg-gray">
        <div class="card-body">
            <h5 class="card-title">Cart Items</h5>
            <table id="cartTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="width: 100px;">Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="cart-items h6">
                    <input type="text" class="form-control" name="ReferNumber" id="employeeNumber" placeholder="Automatically generated" readonly>
                    <?php
                    include('config/db.php');

                    // Fetch data from tbl_receipt
                    $result = mysqli_query($con, "SELECT P_Name, P_price FROM tbl_receipt");

                    // Check if any rows are returned
                    if (mysqli_num_rows($result) > 0) {
                      
                        // Loop through each row and echo out the data
                        while ($row = mysqli_fetch_assoc($result)) {
                            $P_name = $row['P_Name'];
                            $P_price = $row['P_price'];
                            echo "<form method='post' action='config/resibo.php'> ";
                            echo "<input type='hidden' name='name' value = '.$P_name.'> ";
                            echo "<input type='hidden' name='price' value = '.$P_price.'> ";
                            echo "<form method='post' action='config/resibo.php'> ";
                            echo "<tr>";
                            echo "<td>" . $row['P_Name'] . "</td>";
                            echo "<td><input type='number' name='product_quantity[]' class='form-control product-quantity' style='width: 100px;' onchange='calculateSubtotal(this)' required></td>";
                            echo "<td>" . $row['P_price'] . "</td>";
                            echo "<td class='subtotal' name='subtotal[]'>0.00</td>";
                            echo "<td><button class='btn btn-danger delete-btn'>Delete</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no rows are returned, display a message
                        echo "<tr><td colspan='4'>No Order</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div>Total: <span id="totalAmount" name="totalAmount">0.00</span></div>
            <!-- Tendered and Change -->
            <div class="form-group">
                <label for="tenderedAmount">Tendered:</label>
                <input type="number" id="tenderedAmount" class="form-control" value="0.00" name="tenderedAmount" oninput="calculateChange()">
            </div>
            <div>Change: <span id="changeAmount" name="changeAmount">0.00</span></div>
            <input type="hidden" id="totalAmountHidden" name="totalAmount"> <!-- Hidden input for total amount -->
            <button type="submit" id="checkoutBtn" name="checkout" class="btn btn-success" name="order">Checkout</button>
                </form>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    function calculateSubtotal(input) {
        var row = input.parentNode.parentNode;
        var price = parseFloat(row.cells[2].innerText);
        var quantity = parseInt(input.value);
        var subtotal = price * quantity;
        row.cells[3].innerText = subtotal.toFixed(2);
        calculateTotal();
    }

    function calculateTotal() {
        var total = 0;
        var subtotals = document.querySelectorAll('.subtotal');
        subtotals.forEach(function(subtotal) {
            total += parseFloat(subtotal.innerText);
        });
        document.getElementById('totalAmount').innerText = total.toFixed(2);
        calculateChange();
    }

    function calculateChange() {
        var totalAmount = parseFloat(document.getElementById("totalAmount").innerText);
        var tenderedAmount = parseFloat(document.getElementById("tenderedAmount").value);
        var changeAmount = tenderedAmount - totalAmount;
        document.getElementById("changeAmount").innerText = changeAmount.toFixed(2);
    }

         // Function to generate automatic reference number
         function generateReferenceNumber() {
            // Get current date and time
            var date = new Date();
            var timestamp = date.getTime(); // Get timestamp

            // Generate random number between 1000 and 9999
            var random = Math.floor(Math.random() * 9000) + 1000;

            // Combine timestamp and random number to create reference number
            var referenceNumber = 'ORD' + timestamp + random;

            // Set the generated reference number to the input field
            document.getElementById('employeeNumber').value = referenceNumber;
        }

        // Call the function to generate reference number on page load
        generateReferenceNumber();

         function calculateChange() {
        // Get the total amount and tendered amount
        var totalAmount = parseFloat(document.getElementById("totalAmount").innerText);
        var tenderedAmount = parseFloat(document.getElementById("tenderedAmount").value);

        // Calculate the change
        var changeAmount = tenderedAmount - totalAmount;

        // Update the change amount display
        document.getElementById("changeAmount").innerText = changeAmount.toFixed(2);
    }
        </script>

    <!-- Classie --><!-- for toggle left push menu script -->
    <script src="js/classie.js"></script>
<script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
        showLeftPush = document.getElementById('showLeftPush'),
        body = document.body;

    showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
    };

    function disableOther(button) {
        if (button !== 'showLeftPush') {
            classie.toggle(showLeftPush, 'disabled');
        }

        // Remove 'cbp-spmenu-push-toright' class when closing the sidebar
        if (!classie.has(menuLeft, 'cbp-spmenu-open')) {
            classie.remove(body, 'cbp-spmenu-push-toright');
        }
    }
</script>

	<!-- //Classie --><!-- //for toggle left push menu script -->
		
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
	
    </script>
	<!-- //for index page weekly sales java script -->
	
	
	<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
	
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>


    
</body>

</html>
