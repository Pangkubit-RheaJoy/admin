98% of storage used … If you run out, you can't create, edit, and upload files. Get 100 GB of storage for ₱89.00 ₱22.25/month for 3 months.
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

    <div class="row mt-5">

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
            // Close the previous row and start a new row after every 3 cards
            echo '</div><div class="row mt-3">';
        }
        // Display each product in a card
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<img src="uploads/'.$img.'" class="card-img-top">';
        echo' <br>';
        echo ''.$row['productName'].'';
        echo '<input type="hidden" name="product_id" value="'.$row['id'].'">';
        echo '<input type="hidden" name="product_name" value="'.$row['productName'].'">';
        // Add hidden inputs for product price and quantity if needed
        echo '<input type="hidden" name="small" value="'.$row['S_Price'].'">';
        echo '<input type="hidden" name="med" value="'.$row['M_price'].'">';
        echo '<input type="hidden" name="large" value="'.$row['L_price'].'">';
        echo '<input type="hidden" name="product_price" value="'.$row['price'].'">';
        echo '<input type="hidden" name="product_quan" value="'.$row['quantity'].'">';
        
    
        
        echo '<button type="submit" class="btn btn-primary add-to-cart-btn" name="add">Add</button>';
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
                                    <input type="text" class="form-control" name="OrderNo" id="OrderNo" placeholder="Automatically generated" readonly>
                                        <tr>
                                            <th>Product</th>
                                            <th style ="width: 100px;">Quantity</th>
                                            <th>Price</th>
                                        
                                    </thead>
                                    <tbody class="cart-items h6">
                                        <!-- Cart items will be displayed here -->
                                    </tbody>
                                </table>
                                <div>Total: <span id="totalcups" name="totalmaterials"></span></div>
                <div>Total: <span id="totalAmount" name="totalAmount"></span></div>
                                <!-- Tendered and Change -->
                                <div class="form-group">
                                    <label for="tenderedAmount">Tendered:</label>
                                    <input type="number" id="tenderedAmount" class="form-control" value="0.00" name="tenderedAmount" oninput="calculateChange()">
                                </div>
                                <div>Change: <span id="changeAmount" name="changeAmount" value="0.00"></span></div>
                                <input type="hidden" id="totalAmountHidden" name="totalAmount"> <!-- Hidden input for total amount -->
                                <button type="button" id="checkoutBtn" name="checkout" class="btn btn-success" onclick="submitFormWithCartItems()">Checkout</button>



                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForms = document.querySelectorAll('.add-to-cart-btn');
    const tenderedInput = document.getElementById('tenderedAmount');

    // Function to generate automatic reference number
    function generateReferenceNumber() {
        var date = new Date();
        var timestamp = date.getTime(); // Get timestamp
        var random = Math.floor(Math.random() * 9000) + 1000;
        var referenceNumber = 'ORD' + timestamp + random;
        document.getElementById('OrderNo').value = referenceNumber;
    }

    // Call the function to generate reference number on page load
    generateReferenceNumber();

    addToCartForms.forEach(form => {
        form.addEventListener('click', function(event) {
            event.preventDefault();
            const productId = this.parentNode.querySelector('input[name="product_id"]').value;
            const productName = this.parentNode.querySelector('input[name="product_name"]').value;
            const productSmallPrice = parseFloat(this.parentNode.querySelector('input[name="small"]').value);
            const productMediumPrice = parseFloat(this.parentNode.querySelector('input[name="med"]').value);
            const productLargePrice = parseFloat(this.parentNode.querySelector('input[name="large"]').value);
            const productQuantity = parseFloat(this.parentNode.querySelector('input[name="product_quan"]').value);

            const cartItemsContainer = document.querySelector('.cart-items');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${productName}</td>
                <td>
                    <input type="number" name="product_quantity" class="form-control product-quantity" style="width: 100px;" value="${productQuantity}" required>
                    <select class="form-control product-size">
                        <option value="S" data-price="${productSmallPrice}">Small</option>
                        <option value="M" data-price="${productMediumPrice}">Medium</option>
                        <option value="L" data-price="${productLargePrice}">Large</option>
                    </select>
                </td>
                <td class="product-price">${productSmallPrice.toFixed(2)}</td>
                <td><button class="btn btn-danger delete-btn">Delete</button></td>
            `;

            cartItemsContainer.appendChild(newRow);

            // Attach event listener to the delete button of the newly added row
            newRow.querySelector('.delete-btn').addEventListener('click', function() {
                newRow.remove();
                updateTotalAmount();
                updateCategoryQuantities(document.querySelectorAll('.cart-items tr'));
            });

            // Attach event listener to the quantity input field
            newRow.querySelector('.product-quantity').addEventListener('input', function() {
                updateTotalAmount();
                updateCategoryQuantities(document.querySelectorAll('.cart-items tr'));
            });

            // Attach event listener to the product size dropdown
            newRow.querySelector('.product-size').addEventListener('change', function() {
                updateProductPrice(newRow);
                updateTotalAmount();
            });

            updateTotalAmount();
        });
    });

    function updateProductPrice(row) {
        const productSizeSelect = row.querySelector('.product-size');
        const productPriceCell = row.querySelector('.product-price');
        const selectedSize = productSizeSelect.value;
        const selectedSizePrice = parseFloat(productSizeSelect.options[productSizeSelect.selectedIndex].getAttribute('data-price'));
        productPriceCell.textContent = selectedSizePrice.toFixed(2);
    }

    function updateTotalAmount() {
        const totalAmountElement = document.getElementById('totalAmount');
        let totalAmount = 0;
        const rows = document.querySelectorAll('.cart-items tr');
        rows.forEach(row => {
            const quantityInput = row.querySelector('.product-quantity');
            const quantity = parseFloat(quantityInput.value);
            if (!isNaN(quantity)) {
                const selectedSize = row.querySelector('.product-size').value;
                const price = parseFloat(row.querySelector(`option[value="${selectedSize}"]`).getAttribute('data-price'));
                totalAmount += quantity * price;
            }
        });
        totalAmountElement.innerText = totalAmount.toFixed(2);
    }

    function updateCategoryQuantities(rows) {
        let totalCups = 0;
        let totalFlavor = 0;
        let totalStraw = 0;
        rows.forEach(row => {
            const quantity = parseFloat(row.querySelector('.product-quantity').value);
            const size = row.querySelector('.product-size').value;
            switch (size) {
                case 'S':
                    totalCups += quantity;
                    break;
                case 'M':
                    totalFlavor += quantity;
                    break;
                case 'L':
                    totalStraw += quantity;
                    break;
                default:
                    break;
            }
        });
        document.getElementById('totalcups').textContent = totalCups;
        document.getElementById('totalflavor').textContent = totalFlavor;
        document.getElementById('totalstraw').textContent = totalStraw;
    }

    tenderedInput.addEventListener('input', function() {
        calculateChange();
    });

    function calculateChange() {
        const tenderedAmount = parseFloat(tenderedInput.value);
        const totalAmount = parseFloat(document.getElementById('totalAmount').innerText);
        const changeAmountElement = document.getElementById('changeAmount');
        if (!isNaN(tenderedAmount)) {
            const changeAmount = tenderedAmount - totalAmount;
            changeAmountElement.innerText = changeAmount.toFixed(2);
        }
    }
});

function submitFormWithCartItems() {
    const cartItems = document.querySelectorAll('.cart-items tr');
    const cartData = [];
    const orderNo = document.getElementById('OrderNo').value; // Get the OrderNo
    cartItems.forEach(row => {
        const productName = row.querySelector('td:nth-child(1)').innerText;
        const productSize = row.querySelector('.product-size').value; // Get the selected size
        const productQuantity = row.querySelector('.product-quantity').value;
        const productPrice = row.querySelector('td:nth-child(3)').innerText;
        cartData.push({ productName, productSize, productQuantity, productPrice }); // Include product size in the data
    });
    const tenderedAmount = parseFloat(document.getElementById('tenderedAmount').value);
    const TotalMaterial = parseFloat(document.getElementById('totalcups').textContent);
    const totalAmount = parseFloat(document.getElementById('totalAmount').innerText);
    const changeAmount = parseFloat(document.getElementById('changeAmount').innerText);
    const branchId = <?php echo json_encode($_SESSION['Branch_id']); ?>;
    const data = {
        orderNo: orderNo,
        cart: cartData,
        tenderedAmount: tenderedAmount,
        totalAmount: totalAmount,
        changeAmount: changeAmount,
        branch_id: branchId,
        Material: TotalMaterial
    };
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'config/resibo.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            window.location.href = 'receipt.php?Order_No=' + orderNo;
        }
    };
    xhr.send(JSON.stringify(data));
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