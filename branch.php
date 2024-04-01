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
            <div class="col-md-4 col-sm-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        ADD NEW BRANCH
                        <button type="button" class="btn btn-success pull-right" style="margin-top: -10px;"
                            id="toggleForm">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>


                    <div class="panel-body" style="display: none;" id="formContainer">
                    <form method="POST" action="config/insert_branch.php" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Branch Location</label>
                                <input type="text" class="form-control" name="location" required>

                            </div>
                            <div class="form-group">
                                <label>Branch Owner's FullName</label>
                                <input type="text" class="form-control" name="name" required>

                            </div>
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input type="number" class="form-control" name="num" required>

                            </div>

                            <button type="submit" name="added" class="btn btn-primary btn-block btn-sm">Add New Branch</button>
    </form>

                    </div>

                </div>
            </div>


          
            <div class="col-md-8 col-sm-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            BRANCH INFORMATION
        </div>
        <div class="panel-body">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <?php
                // Include database connection file
                include("config/db.php");

                // Fetch data from the database
                $query = "SELECT * FROM tbl_branch";
                $result = mysqli_query($con, $query);

                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='table-responsive' style='max-height: 600px; overflow-y: auto; overflow-x: auto;'>
                            <table class='table table-striped table-bordered table-hover table-fixed' id='dataTables-example' width='100%' cellspacing='0'>
                                <thead>
                                    <tr>
                                        <th style='width: 150px;'>Brach Location</th>
                                        <th style='width: 150px;'>Owner's Fullname</th>
                                        <th style='width: 150px;'>Contact Number</th>
                                        <th style='width: 150px;' class='text-center'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";

                    // Loop through the results and display data
                    while ($row = mysqli_fetch_assoc($result)) {
                        $loc = $row['location'];
                        $name = $row['name'];
                        $num = $row['number'];
                        $id = $row['branch_id'];

                        echo "<tr class='odd gradeX'>
                                <td style='width: 200px;'>$loc</td>
                                <td style='width: 100px;'>$name</td>
                                <td style='width: 100px;'>$num</td>
                                <td style='width: 200px;' class='text-center action-buttons'>
                                    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#editModal$id'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#confirmationModal'>
                                        <i class='fas fa-trash-alt'></i>
                                    </button>
                                </td>
</tr>";

echo "<div class='modal fade' id='editModal$id' tabindex='-1' role='dialog' aria-labelledby='editModalLabel$id' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='editModalLabel$id'>Edit Branch Information</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
    <!-- Your edit form goes here -->
    <form action='config/branchedit.php' method='post' enctype='multipart/form-data'>
        <input type='hidden' name='id' value='$id'>
        <!-- Add your form fields for editing -->

        <div class='form-group'>
            <label for='editName'>Owner's Name:</label>
            <input type='text' class='form-control' id='editName' name='loc' value=' $loc'>
        </div>
        <div class='form-group'>
            <label for='editQuantity'>Quantity:</label>
            <input type='text' class='form-control' id='editQuantity' name='name' value='$name'>
        </div>
        <div class='form-group'>
            <label for='editPrice'>Contact Number:</label>
            <input type='number' class='form-control' id='editPrice' name='num' value='$num'>
        </div>
</div>
<button type='submit' class='btn btn-primary' name='edit'>Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>";
}

}?>


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
                                                                Are you sure you want to delete this room?
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary'
                                                                    data-dismiss='modal'>Close</button>
                                                                <form action="config/deletebranch.php" method="get"
                                                                    style="display: inline;">
                                                                    <input type="hidden" name="delete_id"
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
                            <!--End Advanced Tables -->
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




