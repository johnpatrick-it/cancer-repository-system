<?php
session_start();
error_reporting(0);
include('./includes/config.php');
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
    </style>
</head>

<body>
    <div class="main-wrapper">

        <?php include_once("./includes/header.php"); ?>
        <?php include_once("./includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">

                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="col">
                                <h1 class="page-title">Manage Patients</h1>
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

                    <!-- TABLE -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table datatable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Type of Cancer</th>
                                            <th>Cancer Stage</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>test</td>
                                        <td>
                                            <a href="./edit-patient.php" title="Edit" id="action-btn" class="btn text-xs text-white btn-blue action-icon"><i class="fa fa-pencil"></i></a>
                                            <a href="#" title="Delete" id="action-btn" class="btn text-xs text-white btn-danger action-icon"><i class="fa fa-trash-o"></i></a>
                                        </td>
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
    <script src="./assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="./assets/js/jquery.slimscroll.min.js"></script>

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