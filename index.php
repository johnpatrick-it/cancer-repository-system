<?php
session_start();

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['token']) || empty($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}
error_reporting(0);
include('includes/config.php');
$attemp = 0;

if (!$db_connection) {
    die("Connection failed: " . pg_last_error());
}

$sql = "SELECT COUNT(DISTINCT hospital_id) AS total_hospitals FROM hospital_general_information";

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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var hospitalInfoLink = document.querySelector('a[href="./hospital-information.php"]');
        var adminLoginBtn = document.getElementById('adminLoginBtn');

        hospitalInfoLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action (redirect)
            $('#firstModal').modal('show'); // Show the modal
        });

        adminLoginBtn.addEventListener('click', function() {
            var passwordInput = document.getElementById('passwordInput').value;
            // Here you should validate the password. For simplicity, I'll just check if it's "admin123"
            if (passwordInput === 'admin123') {
                window.location.href =
                    "./hospital-information.php"; // Redirect to hospital information page
            } else {
                // Handle incorrect password case if needed
                alert("Incorrect password. Please try again.");
            }
        });
    });
    </script>
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
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        color: #204A3D;
    }

    .page-header .breadcrumb-item.active,
    .page-header .welcome h3,
    .page-header .close {
        color: #204A3D;

    }

    thead,
    tbody {
        background-color: #d9d9d9;
        color: #204A3D;
        font-size: 0.8rem;
        text-align: center;
    }

    /* Style for chart button container */
    .chartButtonContainer {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .chartButton {
        padding: 8px 15px;
        margin: 0 5px;
        border-radius: 3px;
        background-color: #204A31;
        border: 1px solid #183825;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .chartButton:hover {
        background-color: #2e6946;
        border: 1px solid #53bd7e;
    }

    #chartContainer {
        height: 400px;
        width: 100%;
        border: 1px solid #556b2f;
        border-radius: 5px;
    }

    .cancerDataDashboard {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    @media screen and (max-width: 768px) {
        .cancerDataDashboard {
            flex-direction: column;
            /* Change flex direction for smaller screens */
        }
    }
    </style>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./profiles/pcc-logo1.png">
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
        <!-- Sidebar -->
        <?php include_once("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- WELCOME MESSAGE -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title">Overall Information Statistic</h3>
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
                                    <span class="dash-widget-icon"><i class="fa fa-user-md"></i></span>
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
                                    <span class="dash-widget-icon"><i class="fa fa-hospital-o"></i></span>
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
                    $sql = "SELECT COUNT(*) as total_patients FROM cancer_cases_general_info";
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
                                    <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                    <div class="dash-widget-info">
                                        <h3><?php echo $totalPatients ?></h3>
                                        <span>Total Cases</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="cancerDataDashboard">
                        <div class='tableauPlaceholder' id='viz1710575809354' style='position: relative'><noscript><a
                                    href='#'><img alt='Malupet na dashboard '
                                        src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;re&#47;repo-dashBoard&#47;Malupetnadashboard&#47;1_rss.png'
                                        style='border: none' /></a></noscript><object class='tableauViz'
                                style='display:none;'>
                                <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
                                <param name='embed_code_version' value='3' />
                                <param name='site_root' value='' />
                                <param name='name' value='repo-dashBoard&#47;Malupetnadashboard' />
                                <param name='tabs' value='no' />
                                <param name='toolbar' value='yes' />
                                <param name='static_image'
                                    value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;re&#47;repo-dashBoard&#47;Malupetnadashboard&#47;1.png' />
                                <param name='animate_transition' value='yes' />
                                <param name='display_static_image' value='yes' />
                                <param name='display_spinner' value='yes' />
                                <param name='display_overlay' value='yes' />
                                <param name='display_count' value='yes' />
                                <param name='language' value='en-US' />
                                <param name='filter' value='publish=yes' />
                                <param name='filter'
                                    value='fbclid=IwAR1Te9j-WpSGMwVYMMq8HHiDSNSgFf3kwv2S9Vm2LH9nPe_ZIroQnZhRBpU' />
                            </object></div>
                        <script type='text/javascript'>
                        var divElement = document.getElementById('viz1710575809354');
                        var vizElement = divElement.getElementsByTagName('object')[0];
                        if (divElement.offsetWidth > 800) {
                            vizElement.style.width = '100%';
                            vizElement.style.height = (divElement.offsetWidth * 0.75) + 'px';
                        } else if (divElement.offsetWidth > 500) {
                            vizElement.style.width = '100%';
                            vizElement.style.height = (divElement.offsetWidth * 0.75) + 'px';
                        } else {
                            vizElement.style.width = '100%';
                            vizElement.style.height = '777px';
                        }
                        var scriptElement = document.createElement('script');
                        scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
                        vizElement.parentNode.insertBefore(scriptElement, vizElement);
                        </script>
                    </div>
                </div>
                <div id="firstModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Admin Login</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="adminLoginForm">
                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="text" class="form-control" id="passwordInput" name="passwordInput"
                                            required autocomplete="off">

                                    </div>

                                    <button type="button" class="btn btn-primary" id="adminLoginBtn">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Event listener for when the "Hospital Information" link in the navigation menu is clicked
                    document.querySelector('a[href="./hospital-information.php"]').addEventListener('click',
                        function(event) {
                            // Prevent the default behavior of the link
                            event.preventDefault();

                            // Check if $attemp is equal to 0
                            if (<?= $attemp; ?> === 0) {
                                $('#firstModal').modal('show'); // Show the modal using jQuery
                            } else {
                                // If $attemp is not equal to 0, proceed to the hospital information page
                                window.location.href = "./hospital-information.php";
                            }
                        });
                });
                </script>

                <div id="firstModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Admin Login</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="adminLoginForm">
                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="text" class="form-control" id="passwordInput" name="passwordInput"
                                            required autocomplete="off">

                                    </div>

                                    <button type="button" class="btn btn-primary" id="adminLoginBtn">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

</body>
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


</html>