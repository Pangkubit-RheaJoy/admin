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
            <div class="col-md-12 col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col">
                                PRODUCT INFORMATION REQUEST
                            </div>
                            
                        </div>
                    </div>
        <div class="panel-body">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
         

<?php
include "config/db.php";

// Fetch branch_id of the logged-in user from the session
$user_branch_id = $_SESSION['Branch_id'];

// Define the condition for fetching requests based on the branch_id of the logged-in user
if ($user_branch_id == 0) {
    // If branch_id is 0, fetch all requests where User_branch is 0
    $condition = "";
} else {
    // Otherwise, fetch requests based on the branch_id of the logged-in user
    $condition = "WHERE tbl_request_person.User_branch = $user_branch_id";
}

// Fetch data from the database based on the condition
$query = "SELECT * 
          FROM login 
          INNER JOIN tbl_request_person ON login.UserId = tbl_request_person.User_id
          INNER JOIN requested_materials ON tbl_request_person.Branch_id = requested_materials.ticket_number
          $condition";

$result = mysqli_query($con, $query);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-responsive' style='max-height: 600px; overflow-y: auto; overflow-x: auto;'>
            <table class='table table-striped table-bordered table-hover table-fixed' id='dataTables-example' width='100%' cellspacing='0'>
                <thead>
                    <tr>
                        <th style='width: 150px;'>Ticket Number</th>
                        <th style='width: 150px;'>Received Date</th>
                        <th style='width: 100px;'>Requested By</th>
                        <th style='width: 100px;'>Requested Branch</th>
                        <th style='width: 100px;'>Action</th>
                    </tr>
                </thead>
                <tbody>";
// Group materials by ticket number
$materials_by_ticket = array();
while ($row = mysqli_fetch_assoc($result)) {
    $ticket = $row['ticket_number'];
    if (!isset($materials_by_ticket[$ticket])) {
        $materials_by_ticket[$ticket] = array();
    }
    $materials_by_ticket[$ticket][] = $row;
}

// Loop through grouped materials and display data
foreach ($materials_by_ticket as $ticket => $materials) {
    $request_date = null;
    $confirm_date = null;
    $shipping_date = null;
    $received_date = null;
    $status = null;
    $statusRequest = null; // Define statusRequest variable
    $name = ""; // Initialize name variable
    $loc = ""; // Initialize loc variable

    foreach ($materials as $material) {
        $material_received_date = $material['Received_date'];
        $material_status = $material['Status_id']; // Corrected to use $material instead of $row
        $material_status_def = $material['Status'];
        $name = $material['FN'] . ' ' . $material['LN']; // Set name variable
        $loc = $material['Employno']; // Set loc variable
        $branch_id = $material['branch_id']; // Get branch_id
    }
    // Output table row for each ticket number
    if ($material_status == 3 || $material_status == 5) {
    echo "<tr class='odd gradeX'>
            <td style='width: 150px;'>$ticket</td>
            <td style='width: 150px;'>";

    if ($material_status == 5) {
        echo $material_status_def;
    } else {
        echo $material_received_date;
    }

    echo "</td>
            <td style='width: 150px;'>$name</td>
            <td style='width: 150px;'>$loc</td>
         <td style='width: 100px;'>"; 



        // Output action buttons
        echo "<a href='#' class='view-details' data-toggle='modal' data-target='#confirmationModalRequest$ticket'>
                   View Details
                </a>
            </td>
        </tr>";
   



        // Display modal for each ticket number
        echo "<div class='modal fade' id='confirmationModalRequest$ticket' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Ticket Number: $ticket</h5>
            
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
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
       
            echo "<div class='row'>
                    <div class='col'>
                        <p>$material_material</p>
                    </div>
                    <div class='col'>
                        <p>$material_quantity</p>
                    </div>
                </div>";
        }
    }
}
    echo "</tbody></table></div>";
} else {
    echo "No data found.";
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




