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

// Fetch data from the database based on the branch_id of the logged-in user
$query = "SELECT requested_materials.*, SUM(requested_materials.quantity) AS total_quantity
          FROM requested_materials
          INNER JOIN tbl_branch ON requested_materials.branch_id = tbl_branch.branch_id
          WHERE requested_materials.branch_id = $user_branch_id
          GROUP BY requested_materials.material";


$result = mysqli_query($con, $query);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-responsive' style='max-height: 600px; overflow-y: auto; overflow-x: auto;'>
            <table class='table table-striped table-bordered table-hover table-fixed' id='dataTables-example' width='100%' cellspacing='0'>
                <thead>
                    <tr>
                        <th style='width: 150px;'>Material Name</th>
                        <th style='width: 150px;'>Total Quantity</th>
                    </tr>
                </thead>
                <tbody>";

    // Loop through each row and display the material and total quantity
    while ($row = mysqli_fetch_assoc($result)) {
        $material = $row['material'];
        $total_quantity = $row['total_quantity'];

        // Display row in the table
        echo "<tr>
                <td style='width: 150px;'>$material</td>
                <td style='width: 150px;'>$total_quantity</td>
              </tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "No data found.";
}

mysqli_close($con);
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




