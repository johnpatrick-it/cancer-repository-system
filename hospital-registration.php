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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="cancer-repository-system/assets/css/styleuserprofile.css">
    <title>PCC HRMS</title>

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
    
/* User Profile Img */
.neon-border {
        border: 2px solid #0B72BD;
        box-shadow: 0 0 10px #0B72BD;
    }

    .user-img img {
        width: 6rem;
        height: auto;
    }

    .profile-block {
        margin: 0 0 0 -2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .user-role {
        margin-top: -1.5rem;
    }

    /* ACTIVE NAV STATE */
    .sample-active {
        background-color: #A88C0A;
    }

    /* LOGOUT */
    .out-container .out-button {
        position: fixed;
        bottom: 0;
        left: 0;
    }

    </style>
    <script src="path/to/piechart.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="../assets/plugins/morris/morris.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <style>
    /* DATE AND TIME */
    .page-title-box {
        color: #18372E;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .day {
        font-size: 20px;
        letter-spacing: 0.2rem;
    }

    .date {
        font-size: 12px;
    }

    .time {
        font-size: 15px;
        color: black;
        background-color: white;
        padding: 8px 5px;
        border-left: 4px solid #18372E;
    }

    /* LOGO */
    .header-left {
        background-color: #204A3D;
    }

    /* NOTIFICATION BELL */
    .fa-bell-o {
        color: black;
    }

    /* USER PROFILE */
    .user-img {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .user-img img,
    .user-img span {
        margin: 0;
        width: 1.2rem;
    }

    .user-container .nav-link {
        color: white;
        text-shadow: 1px 1px 2px black;
        font-size: 0.8rem;
    }

    /* WEATHER ICON */
    .weather-icon {
        width: 3.3rem;
    }

    /* TOGGLE ICON */
    .bar-icon span {
        background-color: #000;
    }
</style>

<script>
    // DATE AND TIME
    function updateDateTime() {
        let now = new Date();

        // Format the day
        let dayOptions = {
            weekday: 'long'
        };
        let dayString = now.toLocaleDateString('en-US', dayOptions);
        document.getElementById("day").textContent = dayString + ", ";

        // Format the date
        let dateOptions = {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        };
        let dateString = now.toLocaleDateString('en-US', dateOptions);
        document.getElementById("date").textContent = dateString;

        // Format the time
        let timeOptions = {
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        };
        let timeString = now.toLocaleTimeString('en-US', timeOptions);
        document.getElementById("time").textContent = timeString;
    }

    // Update the date and time every second
    setInterval(updateDateTime, 1000);

    updateDateTime();
</script>

<!-- HEADER -->
 <?php include_once("includes/header.php"); ?>
 <!-- END HEADER -->

<!-- SIDEBAR -->
<?php include_once("includes/sidebar.php"); ?>
<!-- END SIDEBAR -->

 <div class="page-wrapper">
    <div class="content container-fluid">
                <!-- WELCOME MESSAGE -->
        <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title">HOSPITAL REGISTRATION</h3>
                            </div>
                            
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active"></li>
                            </ul>
                        </div>
                    </div>
        </div>

                <!-- METRICS -->
        <div class="row">
            <div class="hospital-table">
            </div>  
        </div>
        <div class="container">
            <div class="row additional-content">
                <div class="search-wrap">
                    <div class="search">
                            <!-- HTML -->
                        <button class="add-hospital-button" onclick="redirectToIndex('back')">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
    <!-- jQuery -->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="../assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/plugins/morris/morris.min.js"></script>
    <script src="../assets/plugins/raphael/raphael.min.js"></script>
    <script src="../assets/js/chart.js"></script>


    <!-- Custom JS -->
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/piechart.js"></script>
    <script src="../assets/js/buttons.js"></script>
    <script>
        function redirectToIndex(action) {
    if (action === 'back') {
        window.location.href = 'hospital-registration.php'; //button to go to hospital information
    }
        }
    </script>

</body>

</html>