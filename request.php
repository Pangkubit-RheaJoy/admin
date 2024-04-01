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
        <?php
include('config/db.php');
$user_branch_id = $_SESSION['Branch_id'];



?>
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
                  

                    <form method="POST" action="config/material_request.php">

                   
                    <?php
$query = "SELECT * FROM tbl_products";
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="form-group">';
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['ProductID'];
            $material = $row['Product_name'];
            echo '<div>';
            echo '<input type="checkbox" name="material[]" value="' . $material . '" onchange="showQuantity(this)"> ' . $material;
            echo '<input type="hidden" name="material_id[]" value="' . $id . '">';
            echo '<input type="number" class="form-control" name="quantity[]" placeholder="Quantity" style="display: none;">';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo 'No materials found.';
    }
} else {
    echo 'Error: ' . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>

<!-- Hidden input fields for date and ticket number -->
<input type="hidden" name="date" value="<?php echo date("Y-m-d"); ?>">
<input type="hidden" name="ticketdate" value="<?php echo time(); ?>">
<input type="hidden" name="branch" value="<?php echo $user_branch_id ?>">
<input type="hidden" name="text" value="Hello! Our branch was requesting a product">
<button type="submit" name="submit" class="btn btn-primary btn-block">Request</button>
</form>

<script>
function showQuantity(checkbox) {
    var quantityInput = checkbox.nextElementSibling.nextElementSibling;
    if (checkbox.checked) {
        quantityInput.style.display = "block";
        quantityInput.setAttribute("name", "quantity[]");
    } else {
        quantityInput.style.display = "none";
        quantityInput.removeAttribute("name"); 
        quantityInput.value = ""; 
    }
}
</script>





</div>
                </div>
            </div>

         
            <div class="col-md-8 col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            PRODUCT INFORMATION REQUEST
        </div>
        <div class="panel-body">
           
            <div class="panel panel-default">
            <?php
include "config/db.php";


$user_branch_id = $_SESSION['Branch_id'];


if ($user_branch_id == 0) {
    
    $condition = "";
} else {

    $condition = "WHERE tbl_request_person.User_branch = $user_branch_id";
}


$query = "SELECT * 
          FROM login 
          INNER JOIN tbl_request_person ON login.UserId = tbl_request_person.User_id
          INNER JOIN requested_materials ON tbl_request_person.Branch_id = requested_materials.ticket_number
          $condition";
$result = mysqli_query($con, $query);


if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-responsive' style='max-height: 600px; overflow-y: auto; overflow-x: auto;'>
            <table class='table table-striped table-bordered table-hover table-fixed' id='dataTables-example' width='100%' cellspacing='0'>
                <thead>
                    <tr>
                        <th style='width: 150px;'>Ticket Number</th>
                        <th style='width: 150px;'>Status</th>
                        <th style='width: 100px;'>Action</th>
                    </tr>
                </thead>
                <tbody>";

 
$materials_by_ticket = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ticket = $row['ticket_number'];
    if (!isset($materials_by_ticket[$ticket])) {
        $materials_by_ticket[$ticket] = array();
    }
    $materials_by_ticket[$ticket][] = $row;
}


foreach ($materials_by_ticket as $ticket => $materials) {
    $request_date = null;
    $confirm_date = null;
    $shipping_date = null;
    $received_date = null;
    $status = null;
    $statusRequest = null; 
    $name = ""; 
    $loc = ""; 

    foreach ($materials as $material) {
        $material_request_date = $material['Request_date'];
        $material_confirm_date = $material['Confirm_date'];
        $material_shipping_date = $material['Shipping_date'];
        $material_received_date = $material['Received_date'];
        $material_status = $material['Status_id'];
        $material_status_def = $material['Status'];
        $name = $material['FN'] . ' ' . $material['LN']; 
        $loc = $material['Employno']; 

        if ($material_request_date && !$request_date) {
            $request_date = $material_request_date;
        }
        if ($material_confirm_date && !$confirm_date) {
            $confirm_date = $material_confirm_date;
        }
        if ($material_shipping_date && !$shipping_date) {
            $shipping_date = $material_shipping_date;
        }
        if ($material_received_date && !$received_date) {
            $received_date = $material_received_date;
        }
        if (!$status) {
            $status = $material_status;
        }

        if (!$statusRequest) { 
            $statusRequest = $material_status_def; 
        }
    }

        if ($status != 3 && $status != 5) {
        echo "<tr class='odd gradeX'>
                <td style='width: 150px;'>$ticket</td>
                <td style='width: 150px;'>$statusRequest</td>
                <td style='width: 100px;'>";

        
        $confirmDisable = ($status == '1' || $status == '2' || $status == '3' || $status == '5') ? "disabled" : "";
        $deleteDisable = ($status == '1' || $status == '2' || $status == '3' || $status == '5') ? "disabled" : "";
        $shipDisable = ( $status == '2' || $status == '3' || $status == '5'|| $status == '0') ? "disabled" : "";
        $doneDisable = ($status == '1' || $status == '3' || $status == '5'|| $status == '0') ? "disabled" : "";

        // Output action buttons
        echo "<button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#confirmationModalRequest$ticket'>
                    <i class='fas fa-edit'></i>
                </button>
            </td>
        </tr>";

        // Display modal for each ticket number
        echo "<div class='modal fade' id='confirmationModalRequest$ticket' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Ticket Number: $ticket</h5>
            
                            <div class='row'>
                                <div class='col'>
                                    <p><strong>Request Date:</strong> $request_date</p>
                                </div>
                                <div class='col'>
                                    <p><strong>Confirm Date:</strong> $confirm_date</p>
                                </div>
                                </div>
                                <div class='row'>
                                <div class='col'>
                                    <p><strong>Shipping Date:</strong> $shipping_date</p>
                                </div>
                                <div class='col'>
                                    <p><strong>Received Date:</strong> $received_date</p>
                                </div>
                            </div>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                        <p><strong>Requested By:</strong>$name</p>
                        <p><strong>Branch Location:</strong>$loc</p>
                            <div class='row'>
                                <div class='col'>
                                    <p><strong>Material</strong></p>
                                </div>
                                <div class='col'>
                                    <p><strong>Quantity</strong></p>
                                </div>
                            </div>";
        foreach ($materials as $material) {
            $material_material = $material['material'];
            $material_quantity = $material['quantity'];
            $material_id = $material['product_id'];
       
            echo "<div class='row'>          
                    <div class='col'>
                        <p>$material_material</p>
                    </div>
                    <div class='col'>
                        <p>$material_quantity</p>
                    </div>
                </div>";
        }
        echo "</div>
<div class='modal-footer'>
    <form action='config/deleteproduct.php' method='post' style='display: inline;'>
        <input type='hidden' value='$ticket' name='id'>
        <button type='submit' class='btn btn-danger btn-sm' name='cancelled' $deleteDisable>
            <i class='fas fa-times'></i>
        </button>
    </form>";

    if ($_SESSION['Branch_id'] == 0) {
    echo"
    <form action='config/confirm_R.php' method='post' style='display: inline;'>
        <input type='hidden' value='$ticket' name='id'>
        <button type='submit' class='btn btn-success btn-sm' name ='confirm' $confirmDisable>
            <i class='fas fa-thumbs-up'></i>
        </button>
    </form>";
    }
// Conditional statement for the ship button
if ($_SESSION['Branch_id'] == 0) {
    // Show the ship button only if Branch_id is 0
    echo "
    <form action='config/ship.php' method='post' style='display: inline;'>
        <input type='hidden' value='$ticket' name='id'>

        <input type='hidden' name='material_id' value=".$material_id.">
        <input type='hidden' value='$material_quantity' name='quantity'>
        <button type='submit' class='btn btn-warning btn-sm' name='ship' $shipDisable>
            <i class='fas fa-truck'></i>
        </button>
    </form>";
}

// Continuing with the rest of the buttons
echo "
    <form action='config/done.php' method='post' style='display: inline;'>
        <input type='hidden' value='$ticket' name='id'>
        <button type='submit' class='btn btn-primary btn-sm' name='done' $doneDisable>
            <i class='fas fa-check'></i>
        </button>
    </form>
</div>
</div>
</div>
</div>
</div>";
 
        }
    }
}
?>

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



