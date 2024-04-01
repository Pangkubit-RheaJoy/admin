<?php
// Start session
session_start();

// Check if user is not logged in
if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Set a message to notify the user
    $_SESSION['message-ok'] = 'You need to log in first.';
    // Redirect to login page
    header("location: login.php");
    exit;
}

// Include necessary files
include('config/db.php');
include('include/navbar.php');
?>
<head>
 
    <!-- Include your CSS and other head elements here -->

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Add your other script includes here if needed -->

    <!-- Add the following script at the end of your HTML file -->
    <script>
        $(document).ready(function() {
            $("#toggleForm").click(function() {
                $("#formContainer").slideToggle();
            });

            // ... other scripts ...
        });
    </script>
</head>

<div id="page-wrapper">


    <div id="page-inner">
        <div class="row">

        </div>


        <div class="row">

            <div class="col-md-4 col-sm-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        REQUEST PRODUCT
                        <button type="button" class="btn btn-success pull-right" style="margin-top: -10px;"
                            id="toggleForm">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>


                    <div class="panel-body" style="display: none;" id="formContainer">
                    <form method="POST" action="config/request.php" enctype="multipart/form-data">

                    <?php
    // Include database connection file
    include("config/db.php");

    // Fetch data from the database
    $query = "SELECT * FROM tbl_products";
    $result = mysqli_query($con, $query); 
?> 

<form method="POST" action="config/addproduct.php" enctype="multipart/form-data">
    <div class="form-group">
        <label>Type Of Product *</label>
        <select name="type_P" class="form-control" required>
            <option value selected></option>
            <option value="Food">Food</option>
            <option value="Drinks">Drinks</option>
        </select>
    </div>
    <div class="form-group">
        <label>Product Name</label>
        <select name="product_name" class="form-control" required>
            <option value selected></option>
            <?php 
            // Iterate through the result set and generate options
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['Product_name'] . "'>" . $row['Product_name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Quantity</label>
        <input type="number" class="form-control" name="P_quantity" required>
    </div>
    <div class="form-group">
        <input type="hidden" class="form-control" name="Status" value="Pending Request" required>
    </div>

    <button type="submit" name="added" class="btn btn-primary btn-block ">Request</button>
</form>


</div>
                </div>
            </div>


          
            <div class="col-md-8 col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            PRODUCT INFORMATION REQUEST
        </div>
        <div class="panel-body">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
            <?php

include "config/db.php";

// Fetch data from the database
$query = "SELECT * FROM tbl_request";
$result = mysqli_query($con, $query);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-responsive' style='max-height: 600px; overflow-y: auto; overflow-x: auto;'>
            <table class='table table-striped table-bordered table-hover table-fixed' id='dataTables-example' width='100%' cellspacing='0'>
                <thead>
                    <tr>
                        <th style='width: 150px;'>Product Type</th>
                        <th style='width: 150px;'>Product Name</th>
                        <th style='width: 100px;'>Quantity</th>
                        <th style='width: 300px;'>Status</th>
                        <th style='width: 300px;'>Action</th>
                    </tr>
                </thead>
                <tbody>";

    // Loop through the results and display data
    while ($row = mysqli_fetch_assoc($result)) {
        $productType = $row['R_type'];
        $productName = $row['R_name'];
        $quantity = $row['R_quantity'];
        $stat = $row['R_status'];
        $statusValue = $row['R_status_value'];
        $id = $row['request_id'];

        // Determine button disable status based on R_status_value
        $confirmDisable = ($statusValue == 1 || $statusValue == 3|| $statusValue == 2) ? "disabled" : "";
        $deleteDisable = ($statusValue == 1 || $statusValue == 2 || $statusValue == 3) ? "disabled" : "";
        $shipDisable = ($statusValue == 2 || $statusValue == 3 || $statusValue == 0) ? "disabled" : "";
        $doneDisable = ($statusValue == 3 || $statusValue == 0 || $statusValue == 1) ? "disabled" : "";

        echo "<tr class='odd gradeX'>
                <td style='width: 200px;'>$productType</td>
                <td style='width: 200px;'>$productName</td>
                <td style='width: 100px;'>$quantity</td>
                <td style='width: 100px;'>$stat</td>
                <td style='width: 100px;'>
                    <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#confirmationModal'$deleteDisable>
                        <i class='fas fa-trash-alt'></i>
                    </button>
                    <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#confirmationModalRequest$id' $confirmDisable>
                        <i class='fas fa-thumbs-up'></i>
                    </button>
                    <button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#ShippModalRequest$id' $shipDisable>
                        <i class='fas fa-truck'></i>
                    </button>
                    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#DoneModalRequest$id' $doneDisable>
                        <i class='fas fa-check'></i>
                    </button>
                </td>
            </tr>";

echo" <div class='modal fade' id='confirmationModalRequest$id' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
<div class='modal-dialog' role='document'>
    <div class='modal-content'>
        <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Confirm Request</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='modal-body'>
            Are you sure you want to confirm this request?
        </div>
        <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <form action='config/confirm_R.php' method='post' style='display: inline;'>
            <input type='hidden' name='done_request' value=".$row['request_id'].">
            <input type='hidden' name='stat' value='Confirm Request'>
            <input type='hidden' name='stat_value' value='1'>
            <button type='submit' class='btn btn-primary' name='confirm_R'>Confirm</button>
        </form>
    </div>
    
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>";

echo "<div class='modal fade' id='ShippModalRequest$id' tabindex='-1'
role='dialog' aria-labelledby='exampleModalLabel'
aria-hidden='true'>
<div class='modal-dialog' role='document'>
    <div class='modal-content'>
        <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Confirm
                Deletion</h5>
            <button type='button' class='close' data-dismiss='modal'
                aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='modal-body'>
    Are you sure you want to ship the products?
</div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
    <form action='config/ship.php' method='post' style='display: inline;'>
        <input type='hidden' name='ship_id' value=". $row['request_id'].">
        <button type='submit' class='btn btn-danger' name='ship'>Ship</button>
    </form>
</div>


    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>";

echo"<div class='modal fade' id='DoneModalRequest$id' tabindex='-1'
role='dialog' aria-labelledby='exampleModalLabel'
aria-hidden='true'>
<div class='modal-dialog' role='document'>
    <div class='modal-content'>
        <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>Confirm
               Receive Product</h5>
            <button type='button' class='close' data-dismiss='modal'
                aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
        </div>
        <div class='modal-body'>
    Are you sure you receive the products?
</div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
    <form action='config/done.php' method='post' style='display: inline;'>
        <input type='hidden' name='done_id' value=". $row['request_id'].">
        <button type='submit' class='btn btn-danger' name='done'>Received</button>
    </form>
</div>


    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>";


                    }
                }
         
                    ?>


                                                <!--Delete Modal-->
                                                <div class='modal fade' id='confirmationModal' tabindex='-1'
                                                    role='dialog' aria-labelledby='exampleModalLabel'
                                                    aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='exampleModalLabel'>Confirm
                                                                    Deletion</h5>
                                                                <button type='button' class='close' data-dismiss='modal'
                                                                    aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                Are you sure you want to cancel this request?
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary'
                                                                    data-dismiss='modal'>Close</button>
                                                                <form action="config/cancelrequest.php" method="get"
                                                                    style="display: inline;">
                                                                    <input type="hidden" name="cancel_id"
                                                                        value="<?php echo $id; ?>">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                


                                            
                                                </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                      
<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


                            <!-- Include jQuery library -->
                            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                            <!-- Add the following script at the end of your HTML file -->
                            <script>
                            $(document).ready(function() {
                                // Delay hiding the alert for 3 seconds
                                setTimeout(function() {
                                    $("#alertMsg").fadeOut(1000); // Fade out over 1 second
                                }, 2000); // 3000 milliseconds = 3 seconds
                            });
                            </script>






                        </div>

                    </div>
                </div>


            </div>

         

        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->

<!-- Classie -->
<!-- for toggle left push menu script -->
<script src="js/classie.js"></script>
<script>
var menuLeft = document.getElementById('cbp-spmenu-s1'),
    showLeftPush = document.getElementById('showLeftPush'),
    body = document.body;

showLeftPush.onclick = function() {
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

<!-- //Classie -->
<!-- //for toggle left push menu script -->

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
<script src="js/bootstrap.js"></script>
    <!-- //Bootstrap Core JavaScript -->
   
</body>

</html>




