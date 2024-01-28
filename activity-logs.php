<?php
session_start();

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit;
}

error_reporting(0);
include('includes/config.php');

// Fetch activity logs from the database
$query = "SELECT * FROM repo_logs";
$result = pg_query($db_connection, $query);

// Check if the query was successful
if (!$result) {
    echo "Error in query: " . pg_last_error($db_connection);
    exit;
}
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

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            background-color: #D4DEDB;
        }

        .body-container {
            background-color: #FAFAFA;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        table {
            text-align: center;
            border: 1px solid #285D4D;
        }

        .page-title {
            font-size: 1.3rem;
            color: #204A3D;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            border: none;
            border-radius: 5px;
            width: 100%;
            border: 1px solid #9E9E9E;
            margin-bottom: 20px;
        }

        .search-input:focus {
            outline: none;
        }

        .search-container i {
            position: absolute;
            right: 15px;
            top: 45%;
            transform: translateY(-50%);
            color: #888;
        }
    </style>
</head>

<body>
    <div class="main-wrapper">

        <?php include_once("includes/header.php"); ?>
        <?php include_once("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Activity Logs</h3>
                            </div>
                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-9">
                            <!-- EMPTY SPACE -->
                        </div>
                        <div class="col-md-3">
                            <div class="search-container">
                                <i class="fa fa-search"></i>
                                <input type="text" class="form-control search-input" placeholder="Search Employee">
                            </div>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table datatable">
                                    <thead>
                                        <tr>
                                            <th>Log-id</th>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        //Query for logid, name and surname nung repo_user na nag registered ng patient
                                            $query_logs = "SELECT rl.log_id, ru.user_fname, ru.user_lname, rl.log_timestamp, rl.log_action
                                                            FROM repo_logs rl
                                                            JOIN repo_user ru ON rl.repo_user_id = ru.repo_user_id
                                                            ORDER BY rl.log_timestamp DESC";
                                            $result_logs = pg_query($db_connection, $query_logs);
                                            if ($result_logs) {
                                                while ($row = pg_fetch_assoc($result_logs)) {
                                                    echo "<tr>";
                                                    echo "<td>{$row['log_id']}</td>";
                                                    echo "<td>{$row['user_fname']}</td>";
                                                    echo "<td>{$row['user_lname']}</td>";
                                                    echo "<td>{$row['log_timestamp']}</td>";
                                                    echo "<td>{$row['log_action']}</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                // Handle the error for the logs query
                                                echo "Error fetching logs: " . pg_last_error($db_connection);
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOR MODAL PURPOSES -->

        </div>
    </div>


    <!-- jQuery -->
    <script src=" assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>

</body>

</html>