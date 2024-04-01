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
    
</head>

<div id="page-wrapper">

<div id="page-inner">
<div class="row">
                    
                    </div> 
   <?php
   // Query to fetch data from a table (assuming you have a 'options' table)
$sql = "SELECT * FROM `tbl_branch`";
$result = $con->query($sql);

// Fetch all rows into an associative array
$options = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

?>
                  
                                     
                <div class="row">
                    
                    <div class="col-md-4 col-sm-5">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            ADD NEW USER
                            <button type="button" class="btn btn-success pull-right" style="margin-top: -10px;"
                                id="toggleForm">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        
    
                        <div class="panel-body" style="display: none;" id="formContainer">
                        <form method="post" action="config/insertuser.php">
                                <div class="form-group">
    
                                <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="ln" required>
            </div>
    
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="fn" required>
            </div>
    
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" name="mn" required>
            </div>
    
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" class="form-control" name="contact" required>
            </div>
    
            <div class="form-group">
                <label>Position</label>
                <select class="form-control" name="position" required>
                <option></option>
                    <option value="Cashier">Cashier</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
    
            <div class="form-group">
    <label>Branch</label>
    <select class="form-control" name="employee_no" required>
        <option></option>
        <?php foreach ($options as $row): ?>
            <option value="<?php echo $row['location']; ?>"><?php echo $row['location']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

    
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" required>
            </div>
    
            <div class="form-group">
                <label>Password</label>
                <input type="text" class="form-control" name="password" required>
            </div>
    
    
                                    
                                        <input type="submit" name="add" value="Add New" class="btn btn-primary btn-block btn-lg">
    
    
                            </form>
                            </form>
                        </div>
                 
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        $("#toggleForm").click(function() {
                            $("#formContainer").slideToggle();
                        });
                    });
                    </script>
    
    
    
                            </div>
                            
                        </div>
                    </div>
                    
                      
        <div class="col-md-8 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                   USER INFORMATION
                </div>
                <div class="panel-body">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <?php
                        $sql = "select * from login limit 0,10";
                        $re = mysqli_query($con, $sql);
                        ?>
                        <div class="panel-body">
    
                            <?php
                            if (isset($_SESSION['msgemployee'])) {
                                echo '<div class="alert alert-success" id="alertMsg" role="alert">' . $_SESSION['msgemployee'] . '</div>';
                                unset($_SESSION['msgemployee']); // Clear the message after displaying it
                            }
    
                            // Display msgDelete
                            if (isset($_SESSION['msgdelete'])) {
                                echo '<div class="alert alert-danger" id="alertMsg" role="alert">' . $_SESSION['msgdelete'] . '</div>';
                                unset($_SESSION['msgdelete']); // Clear the message after displaying it
                            }
    
                            // Display msgEdit
                            if (isset($_SESSION['msgedit'])) {
                                echo '<div class="alert alert-info" id="alertMsg" role="alert">' . $_SESSION['msgedit'] . '</div>';
                                unset($_SESSION['msgedit']); // Clear the message after displaying it
                            }
                            ?>
                            </form>
                        
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th style="width:100%">FullName</th>
                                                <th>Contact</th>
                                                <th>Position</th>
                                                <th>Branch</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th class="text-center">Action</th>
    
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
    while ($row = mysqli_fetch_array($re)) {
        $id = $row['UserId'];
        $fullName = trim($row['FN'] . '  ' . $row['MN'] . '. ' . $row['LN']);
    
        echo "<tr class='odd gradeX'>
        <td>" . $fullName . "</td>
                <td style='width:100%'>" . $row['Cp'] . "</td>
                <td>" . $row['position'] . "</td>
                <td>" . $row['Employno'] . "</td>
                <td>" . $row['UserName'] . "</td>
                <td>********</td>
                <td class='text-center'>
    
    
                    <div class='btn-group'>
                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editModal$id'>
                            <i class='fas fa-edit'></i>
                        </button>
                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#confirmationModal'>
                            <i class='fas fa-trash-alt'></i>
                        </button>
                    </div>
                </td>
            </tr>";
        
    
            // Edit Modal
    echo "<div class='modal fade' id='editModal$id' tabindex='-1' role='dialog' aria-labelledby='editModalLabel$id' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='editModalLabel$id'>Edit User</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <!-- Your edit form goes here -->
                <form action='config/edituser.php' method='post'>
                    <input type='hidden' name='id' value='$id'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label for='editFullName'>Full Name:</label>
                                <input type='text' class='form-control' id='editFullName' name='editFullName' value='$fullName' readonly>
                            </div>
                            <div class='form-group'>
                                <label for='editContact'>Contact:</label>
                                <input type='text' class='form-control' id='editContact' name='editContact' value='" . $row['Cp'] . "'>
                            </div>
                            <div class='form-group'>
                                <label for='editPosition'>Position:</label>
                                <input type='text' class='form-control' id='editPosition' name='editPosition' value='" . $row['position'] . "'>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label for='editEmployeeNo'>Branch Location:</label>
                                <input type='text' class='form-control' id='editEmployeeNo' name='editEmployeeNo' value='" . $row['Employno'] . "'>
                            </div>
                            <div class='form-group'>
                                <label for='editEmail'>Email:</label>
                                <input type='text' class='form-control' id='editEmail' name='editEmail' value='" . $row['UserName'] . "'>
                            </div>
                            <div class='form-group'>
                                <label for='editPassword'>Password:</label>
                                <input type='password' class='form-control' id='editPassword' name='editPassword' placeholder='Enter new password'>
                            </div>
                        </div>
                    </div>
                    <button type='submit' class='btn btn-primary' name='edit'>Save Changes</button>
                </form>
            </div>
        </div>
    </div>
    </div>";
    
        }
        ?>
    
    
    <!--Delete Modal-->
    <div class='modal fade' id='confirmationModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Confirm Deletion</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    Are you sure you want to delete this room?
                </div>
                <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        <form action="config/deleteuser.php" method="get" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
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




