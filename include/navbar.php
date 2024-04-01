<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="designlins/style.css" rel='stylesheet' type='text/css' />
    <!-- font-awesome icons CSS -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons CSS-->

    <!-- side nav css file -->
    <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css' />
    <!-- //side nav css file -->

    <!-- js-->
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <!--//webfonts-->
  
    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <!-- chart -->
    <script src="js/Chart.js"></script>
    <!-- //chart -->

    <!-- Metis Menu -->
    <script src="js/metisMenu.min.js"></script>
    <script src="js/custom.js"></script>
    <link href="css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
    <style>
        #chartdiv {
            width: 100%;
            height: 295px;
        }
    </style>

</head>
<?php
session_start(); // Start the session

$user_branch_id = $_SESSION['Branch_id'];

?>

<body class="cbp-spmenu-push">
    <div class="main-content">
        <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
            <!--left-fixed -navigation-->
            <aside class="sidebar-left">
                <nav class="navbar navbar-inverse">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse"
                            aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <h1><a class="navbar-brand" href="index.html"><span class="fa fa-home "></span> Branch<span class="dashboard_text">Management
                                    System</span></a></h1>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="sidebar-menu">
                            <p class='text-white'>Welcome Back, <?= $_SESSION['NameOfUser']?></p>
                            <?php if ($user_branch_id != 0): ?>
                            <li class="treeview">
                                <a href="cashier.php">
                                    <i class="fa fa-laptop"></i>
                                    <span>Cashier</span>
                                  
                                </a>
                                
                            </li>
                            <?php endif; ?>
                            <?php
include('config/db.php');

try {
    // Prepare SQL statement to count distinct ticket_numbers with status_id = 0
    $sql = "SELECT COUNT(DISTINCT ticket_number) AS count FROM requested_materials WHERE status_id = 0";
    $result = $con->query($sql);
    
    // Fetch the count
    if ($result) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
    } else {
        $count = 0;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


?>


<li class="header">PRODUCT MANAGEMENT</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-laptop"></i>
        <span>Products</span>
        <?php if ($user_branch_id == 0): ?>
        <?php if ($count > 0): ?>
            <span class="badge bg-danger pull-right"><?php echo $count; ?></span>
        <?php endif; ?>
        <i class="fa fa-angle-left pull-right"></i>
        <?php endif; ?>
    </a>
    <ul class="treeview-menu">
        <?php if ($user_branch_id == 0): ?>
            <li>
                <a href="material.php">Add Materials
                <?php if ($count > 0): ?>
                    <span class="badge bg-danger pull-right"><?php echo $count; ?></span>
                <?php endif; ?>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
            </li>
            <li><a href="product.php">Add Product</a></li>
        <?php endif; ?>
        <?php if ($user_branch_id != 0): ?>
            <li><a href="request.php">Request</a></li>
        <?php endif; ?>
    </ul>
</li>





                            <li class="header">BRANCH MANAGEMENT</li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-laptop"></i>
                                    <span>Management</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if ($user_branch_id == 0): ?>
                                        <li><a href="branch.php">Branch Management</a></li>
                                        <li><a href="staff.php">Staff Management</a></li>
                                    <?php endif; ?>
                                    <li><a href="report.php">Report</a></li>
                                    <li><a href="sales.php">Sales</a></li>
                                </ul>
                            </li>
                            <li class="header">ACCOUNT MANAGEMENT</li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-laptop"></i>
                                    <span>Account Setting</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#">Setting</a></li>
                                    <li><a href="config/logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </aside>
        </div>
        <!--left-fixed -navigation-->
   



        <!-- header-starts -->
        <div class="sticky-header header-section ">
            <div class="header-left">
                <!--toggle button start-->
                <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                <!--toggle button end-->
                <div class="clearfix"> </div>
            </div>
            <div class="header-right">

                
                <div class="clearfix"> </div>
            </div>

        </div>
        <!-- //header-ends -->

        <!-- ... rest of your HTML code ... -->

    </div>
    <!-- /.main-content -->

    <!-- ... rest of your HTML code ... -->

</body>

</html>

