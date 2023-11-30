<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="This is a Philippine Cancer Center HR Management System">
    <meta name="keywords" content="PCC-HRMS, HRMS, Human Resource, Capstone, System, HR">
    <meta name="author" content="Heionim">
    <meta name="robots" content="noindex, nofollow">
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

        .filter-btn,
        .export-btn {
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

        <?php include_once("includes/header.php"); ?>
        <?php include_once("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="body-container">

                    <!-- HEADER -->
                    <div class="page-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="page-title">Hospital Information</h3>
                            </div>
                        </div>
                    </div>

                    <!-- SEARCH -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="search-container">
                                <i class="fa fa-search"></i>
                                <input type="text" class="form-control pl-5 search-input" placeholder="Search">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- Empty Space -->
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-auto ml-auto m-right">
                                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_hospital">
                                        <i class="fa fa-medkit"></i> Add Hospital
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <button class="btn filter-btn  m-right">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn export-btn">
                                        <i class="fa fa-download"></i> Export
                                    </button>
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
                                            <th>Hospital Name</th>
                                            <th>Hospital Level</th>
                                            <th>Type of Instituion</th>
                                            <th>Hospital Location UACS CODE</th>
                                            <th>Hospital Street</th>
                                            <th>Hospital Equipments</th>
                                            <th class="no-sort">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>NULL</td>
                                            <td>NULL</td>
                                            <td>NULL</td>
                                            <td>NULL</td>
                                            <td>NULL</td>
                                            <td>NULL</td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#edit_hospital" title="Edit" class="btn text-xs text-white btn-blue action-icon"><i class="fa fa-pencil"></i></a>
                                                <a href="#" data-toggle="modal" data-target="#delete_hospital" title="Delete" class="btn text-xs text-white btn-danger action-icon"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Hospital  Modal -->
            <?php include_once 'includes/modals/hospital/add_hospital.php'; ?>

            <!-- Edit Hospital Modal -->
            <?php include_once 'includes/modals/hospital/edit_hospital.php'; ?>

            <!-- Delete Hospital Modal -->
            <?php include_once 'includes/modals/hospital/delete_hospital.php'; ?>
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