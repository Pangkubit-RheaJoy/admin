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
<style>
    .bg-hex{
    background-color:#7095ac;
    }
</style>
<div id="page-wrapper">

<div id="page-inner">
<div class="row">
            <div class="col-md-12 col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col">
                                SALES INFORMATION 
                            </div>
                            
                        </div>
                    </div>
                    <div class="panel-body">

<!-- Advanced Tables -->
<div class="panel panel-default">
    <div class="panel-body">
        <?php
        include "config/db.php";
        $user_branch_id = $_SESSION['Branch_id'];
        // Execute the SQL query
        if ($user_branch_id == 0) {
            // Show all branches
            $query = "SELECT `branch_id`, `name`, `location` FROM `tbl_branch`";
        } else {
            // Show only the branch corresponding to the logged-in user
            $query = "SELECT `branch_id`, `name`, `location` FROM `tbl_branch` WHERE `branch_id` = $user_branch_id";
        }
        
        $result = mysqli_query($con, $query);
        
        // Check if there are any rows returned
        if (mysqli_num_rows($result) > 0) {
            // Initialize a counter to keep track of cards per row
            $cards_per_row = 3;
            $card_counter = 0;
            
            // Start the row
            echo '<div class="row">';
            
            // Loop through each row and display in a card
            while ($row = mysqli_fetch_assoc($result)) {
                // Start a column for each card
                echo '<div class="col-md-4">';
                echo '<div class="card text-center bg-hex" style="height: 150px;">'; // Set height and background color here
                echo '<div class="card-body">';
                // Display name and location in the card body
                echo '<i class="fas fa-map-marker-alt"></i><h5 class="card-title text-light">' . $row['location'] . '</h5>';   
                // Add the "View Report" button with Bootstrap classes
                echo '<a href="report_sales.php?location_id=' . $row['branch_id'] . '&location=' . urlencode($row['location']) . '" class="btn btn-success">View Report</a>';

                echo '</div>'; // Close card-body
                echo '</div>'; // Close card
                echo '</div>'; // Close column

                // Increment the card counter
                $card_counter++;
                
                // If we've reached the desired number of cards per row, close the row and start a new one
                if ($card_counter % $cards_per_row === 0) {
                    echo '</div>'; // Close row
                    // Start a new row
                    echo '<div class="row">';
                }
            }

            // Close any open row
            if ($card_counter % $cards_per_row !== 0) {
                echo '</div>'; // Close row
            }
            
        } else {
            // No data available
            echo "No data available";
        }
        
        // Close the database connection
        mysqli_close($con);
        ?>
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




