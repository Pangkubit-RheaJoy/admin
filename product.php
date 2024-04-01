<?php
// Assuming you have a database connection established already

include ('config/db.php');
include ('include/navbar.php');


?>

<head>

    <!-- Include your CSS and other head elements here -->

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Add your other script includes here if needed -->

    <!-- Add the following script at the end of your HTML file -->
    <script>
        $(document).ready(function () {
            $("#toggleForm").click(function () {
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
                ADD NEW PRODUCTS
                <button type="button" class="btn btn-success pull-right" style="margin-top: -10px;" id="toggleForm">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="panel-body" style="display: none;" id="formContainer">
                <form method="POST" action="config/addcashproduct.php" enctype="multipart/form-data">
                    <?php
                    $user_branch_id = $_SESSION['Branch_id'];
                    echo "<input type='hidden' name='branch_id' value='$user_branch_id'>";
                    ?>

                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" name="P_name" required>
                    </div>
                    <div class="form-group">
                        <label>Drink Sizes</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Small</label>
                                <input type="text" class="form-control" name="small_price" placeholder="Price">
                            </div>
                            <div class="col-md-4">
                                <label>Medium</label>
                                <input type="text" class="form-control" name="medium_price" placeholder="Price">
                            </div>
                            <div class="col-md-4">
                                <label>Large</label>
                                <input type="text" class="form-control" name="large_price" placeholder="Price">
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="added" class="btn btn-primary btn-block">Add Material</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                MATERIAL INFORMATION
            </div>
            <div class="panel-body">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                <?php
    
    // Fetch data from the database
    $query = "SELECT *
                FROM tbl_cashproduct"; 
              
              
              

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive' style='max-height: 600px; overflow-y: auto; overflow-x: auto;'>
                <table class='table table-striped table-bordered table-hover table-fixed' id='drinkTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                            <th style='width: 100px;'>Image</th>
                            <th style='width: 200px;'>Product Name</th>
                            <th style='width: 300px;'>Drink Details</th>
                            <th style='width: 100px;' class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            // Retrieve data for each drink product
            // Adjust this part based on your database schema
            $productName = $row['productName'];
            $img = $row['img'];
            $id = $row['id'];
            $P_small = $row['S_Price'];
            $P_medium = $row['M_price'];
            $P_large = $row['L_price'];
            $type = $row['productType'];

            echo "<tr class='odd gradeX'>
                    <td style='width: 100px;'><img src='uploads/$img' style='max-width: 100px; height: auto;'></td>
                    <td style='width: 200px;'>$productName</td>
                    <td style='width: 300px;'>
                        <table class='table'>
                            <tr>
                                <th style='width: 100px;'>Size</th>
                                <th style='width: 100px;'>Price</th>
                            </tr>
                            <tr>
                                <td>Small</td>
                                <td>$P_small</td>
                            </tr>
                            <tr>
                                <td>Medium</td>
                                <td>$P_medium</td>
                            </tr>
                            <tr>
                                <td>Large</td>
                                <td>$P_large</td>
                            </tr>
                        </table>
                    </td>
                    
                    <td style='width: 100px;' class='text-center action-buttons'>
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
                                            <h5 class='modal-title' id='editModalLabel$id'>Edit Product</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <form action='config/editprodductcash.php' method='post' enctype='multipart/form-data'>
                                                <input type='hidden' name='id' value='$id'>
                                                <input type='hidden' name='type' value=' $type'>
                                                <!-- Add your form fields for editing -->
                                                <div class='form-group'>
                                                    <label for='editName'>Product Name:</label>
                                                    <input type='text' class='form-control' id='editName' name='P_name' value='$productName'>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Small Size</label>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label>Price:<input type='number' class='form-control' name='S_price' value='$P_small'></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Medium Size</label>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label>Price:<input type='number' class='form-control' name='M_price' value='$P_medium'></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label>Large Size</label>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label>Price:<input type='number' class='form-control' name='L_price' value='$P_large'></label>
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
}
                    ?>

                    <!-- Delete Modal -->
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
                                    Are you sure you want to delete this product?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                    <form action="config/deleteprod.php" method="get" style="display: inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-danger">Delete</button>
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


            <!-- Include jQuery and Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


            <!-- Include jQuery library -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <!-- Add the following script at the end of your HTML file -->
            <script>
                $(document).ready(function () {
                    // Delay hiding the alert for 3 seconds
                    setTimeout(function () {
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