<?php
session_start();

if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit; 
}
error_reporting(0);
include('includes/config.php');

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
    <title>PCC CANCER REPOSITORY</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="./assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="./assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">

    <style>
        .page-header {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
        }

        .page-header .breadcrumb-item.active,
        .page-header .welcome h3 {
            color: #204A3D;
            font-size: 2rem;
            font-weight: 700;
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
            font-weight: 900;
        }

        .btn-blue {
            background-color: #0D6EFD;
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
            left: 15px;
            top: 45%;
            transform: translateY(-50%);
            color: #888;
        }

        .filter-btn {
            padding: 8px 20px;
            background-color: #E5F6F1;
            color: #204A3D;
            border: 1px solid #204A3D;
        }

        .add-btn {
            border-radius: 5px;
            padding: 8px 2rem;
        }

        .m-right {
            margin-right: -0.8rem;
        }

        .card-body {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0.5rem;
        }

        .card-body h3 {
            font-weight: 700;
        }

        .card-body .span-text {
            font-size: 1.2rem;
            font-weight: 900;
        }
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include_once("includes/user-header.php"); ?>
        <?php include_once("includes/user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">

                <!-- WELCOME MESSAGE -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title">Display Hospital Name</h3>

                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- METRICS -->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info">
                                    <h3>32</h3>
                                    <span class="span-text">New Patients</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                <div class="dash-widget-info">
                                    <h3>341</h3>
                                    <span class="span-text">Total Patients</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PATIENT INFO -->
                <div class="body-container">

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="col">
                                <h1 class="page-title">Patient Info</h1>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 ml-auto m-right">
                                    <div class="search-container ">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="form-control pl-5 search-input" placeholder="Search">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="">
                                        <button class="btn filter-btn">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Assuming you have already established a PostgreSQL connection ($db_connection) -->

<!-- TABLE -->
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped custom-table datatable">
                <thead>
                    <tr>
                        <th>Patient Type</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Gender</th>
                        <th>Cancer Stage</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //FUNCTION NG CODE NA TO IS:
                    //KUKUHAIN NYA KUNG ANONG HOSPITAL NI CURRENT REPO_USER LOGIN SESSION
                    //THEN I S-SAVE YUNG HOSPITAL-ID
                    //THEN I QUERY KUNG ANONG PATIENT IS YUNG EQUAL DOON SA HOSPITAL-ID NA YON AT AYON YUNG I D-DISPLAY SA TABLE
                    if (!$db_connection) {
                        echo "Failed to connect to the database.";
                    } else {
                        $repo_user_id = $_SESSION['repo_user_id'];
                    //QUERY PARA SA HOSPITAL ID THE I S-SAVE AS $HOSPITAL_ID
                        $query_affiliation = "SELECT hospital_id FROM repo_user WHERE repo_user_id = '$repo_user_id'";
                        $result_affiliation = pg_query($db_connection, $query_affiliation);
                        
                        if (!$result_affiliation) {
                            echo "Error in query_affiliation: " . pg_last_error($db_connection);
                            exit;
                        }

                        $row_affiliation = pg_fetch_assoc($result_affiliation);

                        $hospital_id = $row_affiliation['hospital_id'];

                        // PUTANG INANG SQL JOIN TO PUTANG INA MO
                        $query = "
                            SELECT 
                                pgi.type_of_patient,
                                pgi.patient_last_name,
                                pgi.patient_first_name,
                                pgi.sex,
                                pci.cancer_stage,
                                pci.patient_status
                            FROM 
                                patient_general_info pgi
                            JOIN 
                                patient_cancer_info pci ON pgi.patient_id = pci.patient_id
                            JOIN
                                hospital_general_information hgi ON pgi.hospital_id = hgi.hospital_id
                            WHERE
                                hgi.hospital_id = '$hospital_id'
                        ";
                        $result = pg_query($db_connection, $query);

                        if (!$result) {
                            echo "Error in query: " . pg_last_error($db_connection);
                            exit;
                        }
                        //TABLE DISPLAY
                        while ($row = pg_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['type_of_patient'] . "</td>";
                            echo "<td>" . $row['patient_last_name'] . "</td>";
                            echo "<td>" . $row['patient_first_name'] . "</td>";
                            echo "<td>" . $row['sex'] . "</td>";
                            echo "<td>" . $row['cancer_stage'] . "</td>";
                            echo "<td>" . $row['patient_status'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                    }

                    pg_close($db_connection);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
    <script src="assets/js/chart.js"></script>

    <!-- Select2 JS -->
    <script src="./assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="./assets/js/moment.min.js"></script>
    <script src="./assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="./assets/js/jquery.dataTables.min.js"></script>
    <script src="./assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="./assets/js/app.js"></script>
</body>

</html>