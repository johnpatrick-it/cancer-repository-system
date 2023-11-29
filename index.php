<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
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
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                                <div class="dash-widget-info">
                                    <h3>15</h3>
                                    <span>New Cases</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info">
                                    <h3>2</h3>
                                    <span>Total Hospitals</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                                <div class="dash-widget-info">
                                    <h3>15</h3>
                                    <span>Total Cases</span>
                                </div>
                            </div>
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