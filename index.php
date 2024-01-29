<?php
session_start();

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit; 
}
error_reporting(0);
include('includes/config.php');

if (!$db_connection) {
    die("Connection failed: " . pg_last_error());
}

// Query to count the number of hospitals in the table
$sql = "SELECT COUNT(*) as total_hospitals FROM hospital_general_information";

$result = pg_query($db_connection, $sql);

if (!$result) {
    printf("Error: %s\n", pg_last_error($db_connection));
    exit();
}

$totalHospitals = 0;
if (pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    $totalHospitals = $row["total_hospitals"];
}

// Query to count the number of repo_users in the table
$sql_repo_users = "SELECT COUNT(*) as total_repo_users FROM repo_user";

$result_repo_users = pg_query($db_connection, $sql_repo_users);

if (!$result_repo_users) {
    printf("Error: %s\n", pg_last_error($db_connection));
    exit();
}

$totalRepoUsers = 0;
if (pg_num_rows($result_repo_users) > 0) {
    $row_repo_users = pg_fetch_assoc($result_repo_users);
    $totalRepoUsers = $row_repo_users["total_repo_users"];
}

pg_close($db_connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="This is a Philippine Cancer Repository System">
    <meta name="keywords" content="PCC-CR, CR, Cancer Repository, Capstone, System, Repo">
    <meta name="author" content="Heionim">
    <meta name="robots" content="noindex, nofollow">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <title>PCC CANCER REPOSITORY</title>

    <style>
        .page-header {
            background-color: #204A3D;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
        }

        .page-header .breadcrumb-item.active,
        .page-header .welcome h3,
        .page-header .close {
            color: #F0F0F0;
        }

        h2 {
            font-size: 1rem;
            border-bottom: 2px solid #ccc;
            padding: 0.5rem;
        }

        thead,
        tbody {
            background-color: #d9d9d9;
            color: #204A3D;
            font-size: 0.8rem;
            text-align: center;
        }

        /* CALENDAR CHART */
        #calendar {
            max-width: 600px;
            margin: 0 auto;
            border-collapse: collapse;
        }

        #calendar th,
        #calendar td {
            width: 14.28%;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        #calendar th {
            background-color: #f2f2f2;
        }

        .event {
            background-color: #4CAF50;
            color: #fff;
            padding: 2px;
            border-radius: 4px;
            display: block;
            margin-top: 5px;
        }

        #month-year {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php include_once("includes/header.php"); ?>
        <!-- End Header -->

        <!-- Sidebar -->
        <?php include_once("includes/sidebar.php"); ?>
        <!-- End Sidebar -->


        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- WELCOME MESSAGE -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title">CANCER REPOSITORY DASHBOARD</h3>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- METRICS -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <a href="user-information.php">
                            <div class="card dash-widget">
                                <div class="card-body">
                                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                    <div class="dash-widget-info">
                                        <h3><?php echo $totalRepoUsers; ?></h3>
                                        <span>Total Users</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <a href="hospital-information.php">
                            <div class="card dash-widget">
                                <div class="card-body">
                                    <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                    <div class="dash-widget-info">
                                        <h3><?php echo $totalHospitals; ?></h3>
                                        <span>Total Hospitals</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        // Add your SQL query to count the total number of patients
                        $sql = "SELECT COUNT(*) as total_patients FROM patient_general_info";

                        $result = pg_query($db_connection, $sql);

                        // Check if the query was successful
                        if ($result) {
                            // Fetch the count from the result
                            $row = pg_fetch_assoc($result);
                            $totalPatients = $row["total_patients"];

                            // Free result set
                            pg_free_result($result);
                        } else {
                            // Handle the case where the query fails
                            echo "Error in query: " . pg_last_error($db_connection);
                            $totalPatients = 0; // Set a default value
                        }
                        ?>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <a href="activity-logs.php">
                                <div class="card-body">
                                    <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                    <div class="dash-widget-info">
                                        <h3><?php echo $totalPatients ?></h3>
                                        <span>Total Patient</span>
                                    </div>
                                </div>
                            </a>    
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="wrap">
                        <div class="chartButtonContainer">
                            <!-- Nasa ASSETS JS yung chart file-->
                            <button id="pieChartBtn" class="chartButton" id="specificId">Pie Chart</button>
                            <button id="barChartBtn" class="chartButton" id="specificId">Line Chart</button>
                        </div>
                    </div>
                    <!-- CHART TABLE -->
                        <div id="chartContainer" style="height: 400px; width: 100%;"></div>
                        <!-- CHART TABLE END-->
                </div>
            </div>
        </div>
    </div>


    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/js/chart.js"></script>


    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/piechart.js"></script>
    <script src="assets/js/barchart.js"></script>
    <script src="assets/js/chart-switcher.js"></script>

</body>

</html>