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

    .top{
        margin-top:-95px;
    }
</style>

<div id="page-wrapper">
<button type="button" onclick="location.href='sales.php'" class="btn btn-primary top" >Back</button>
 <div id="page-inner">
   <div class="row">
        
   <div class="col-md-9 col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col">
                    SALES INFORMATION
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php
            include "config/db.php";

            // Pagination variables
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $records_per_page = 10;
            $offset = ($page - 1) * $records_per_page;

            if (isset($_GET['location_id'])) {
                // Sanitize the location_id to prevent SQL injection
                $location_id = mysqli_real_escape_string($con, $_GET['location_id']);
                $location = mysqli_real_escape_string($con, $_GET['location']);

                // Execute the SQL query to fetch data for the specific branch with pagination
                $query = "SELECT date, SUM(total) AS total_sales
                          FROM tbl_sales
                          WHERE branch_id = $location_id
                          GROUP BY date
                          LIMIT $offset, $records_per_page";

                $result = mysqli_query($con, $query);

                // Check if there are any rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Display sales information
                    echo "<div class='panel panel-default'>";
                    echo "<div class='panel-body'>";
                    echo "<h3>Sales Information for Branch in $location</h3>";
                    echo "<table class='table table-striped'>";
                    echo "<thead>
                                <tr>
                                    <th>Sale Date</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['total_sales'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";

                    // Pagination links
                    $query = "SELECT COUNT(*) AS total_records
                              FROM tbl_sales
                              WHERE branch_id = $location_id";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);
                    $total_records = $row['total_records'];
                    $total_pages = ceil($total_records / $records_per_page);

                    echo "<ul class='pagination'>";
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li><a href='?location_id=$location_id&location=$location&page=$i'>$i</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "No sales in the Branch:  $location";
                }
            } else {
                header("Location: sales.php");
                exit();
            }

            mysqli_close($con);
            ?>
            <!-- End of PHP code -->
        </div>
    </div>
</div>

            <!-- Right Panel with Cards -->
<div class="col-md-3 col-sm-6">
    <!-- Card 1: Weekly Sales -->
    <div class="card mb-3">
        <div class="card-header bg-info text-white">
            Weekly Sales
        </div>
        <div class="card-body">
            <?php
            include "config/db.php";

            // Query to fetch total sales per week
            $query_weekly_sales = "SELECT WEEK(date) AS week_number, SUM(total) AS total_sales
                                    FROM tbl_sales
                                    WHERE branch_id = $location_id
                                    GROUP BY WEEK(date)";
            $result_weekly_sales = mysqli_query($con, $query_weekly_sales);

            // Display weekly sales
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result_weekly_sales)) {
                echo "<li>Week " . $row['week_number'] . ": ₱" . $row['total_sales'] . "</li>";
            }
            echo "</ul>";

            // Close the database connection
            mysqli_close($con);
            ?>
        </div>
    </div>

    <!-- Card 2: Monthly Sales -->
    <div class="card mb-3">
        <div class="card-header bg-warning text-white">
            Monthly Sales
        </div>
        <div class="card-body">
            <?php
            include "config/db.php";

            // Query to fetch total sales per month
            $query_monthly_sales = "SELECT MONTHNAME(date) AS month, SUM(total) AS total_sales
                                    FROM tbl_sales
                                    WHERE branch_id = $location_id
                                    GROUP BY MONTH(date)";
            $result_monthly_sales = mysqli_query($con, $query_monthly_sales);

            // Display monthly sales
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result_monthly_sales)) {
                echo "<li>" . $row['month'] . ": ₱" . $row['total_sales'] . "</li>";
            }
            echo "</ul>";

            // Close the database connection
            mysqli_close($con);
            ?>
        </div>
    </div>

    <!-- Card 3: Yearly Sales -->
    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            Yearly Sales
        </div>
        <div class="card-body">
            <?php
            include "config/db.php";

            // Query to fetch total sales per year
            $query_yearly_sales = "SELECT YEAR(date) AS year, SUM(total) AS total_sales
                                    FROM tbl_sales
                                    WHERE branch_id = $location_id
                                    GROUP BY YEAR(date)";
            $result_yearly_sales = mysqli_query($con, $query_yearly_sales);

            // Display yearly sales
            echo "<ul>";
            while ($row = mysqli_fetch_assoc($result_yearly_sales)) {
                echo "<li>" . $row['year'] . ": ₱" . $row['total_sales'] . "</li>";
            }
            echo "</ul>";

            // Close the database connection
            mysqli_close($con);
            ?>
        </div>
    </div>
</div>
<div class="col-md-9 col-sm-6">
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

// Check if branch_id is provided
if (isset($location_id)) {
    // Execute the SQL query to fetch stocks for the specific branch
    $query = "SELECT requested_materials.*, SUM(requested_materials.quantity) AS total_quantity
    FROM tbl_request_person
    INNER JOIN requested_materials ON tbl_request_person.Branch_id = requested_materials.ticket_number
    INNER JOIN tbl_branch ON tbl_branch.branch_id = tbl_request_person.User_branch
    WHERE tbl_request_person.User_branch = $location_id
    GROUP BY requested_materials.material
    ";

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
} else {
    echo "Branch ID is not provided.";
}

// Close the database connection
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




