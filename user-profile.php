<?php
session_start();

//VERY IMPORTANT DONT ERASE
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}


// Access the hospital name from the session variable
$hospital_name = $_SESSION['hospital_name'];

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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <title>PCC CANCER REPOSITORY</title>

    <style>
    .page-header {
    background-color: #f8f9fa;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    border-bottom: 1px solid black; /* Added bottom border only */
    color: #000; /* Changed text color to black */
}


        .page-header .breadcrumb-item.active,
        .page-header .welcome h3,
        .page-header .close {
            color: #204A3D;
        }

        
        @media only screen and (max-width: 768px) {
  
  .img-border {
  display:flex;
  justify-content:center;
  height:130px;
  width:130px;
}
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
        .img-align {            
            display:flex;
            justify-content: center;
            align-items: center;
            margin:0 80px;
        }

        .img-border {
            display:flex;
            justify-content:center;
            height:130px;
            width:130px;
        }

        .user-name {
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:1.4rem;
        }
        @media only screen and (max-width: 768px) {
  
            .img-border {
            display:flex;
            justify-content:center;
            height:130px;
            width:130px;
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
        <?php include_once("includes/user-header.php"); ?>
        <!-- Sidebar -->
        <?php include_once("includes/user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- WELCOME MESSAGE -->
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title">Account Profile</h3>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="img-align">
                <img class="img-border" src="./profiles/pcc-logo1.png" alt="">
                </div>
                
                <span class="user-name"><?php echo $_SESSION['user_lname'] . "," . " " . $_SESSION['user_fname']?></span>
                 <!-- WELCOME MESSAGE -->
                 <div class="page-header">
                                        
                </div>              
                    <section>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="welcome d-flex justify-content-between align-items-center">
                                <h3 class="page-title-1">Personal Information</h3>
                            </div>
                           
                        </div>
                    </div>  
            
                                <div class="row justify-content-center" style="margin-top:20px;">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label class="custom-label">Given name</label>
                                        <input name="surname" type="text" class="form-control" required="true" autocomplete="off" value=" <?php echo $_SESSION['user_fname']?>">

                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label class="custom-label">Surname name</label>
                                        <input name="given_name" type="text" class="form-control" required="true" autocomplete="off" value=" <?php echo $_SESSION['user_lname']?>">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label class="custom-label">Middle Name</label>
                                        <input name="middle_name" type="text" class="form-control" required="true" autocomplete="off" value=" <?php echo $_SESSION['user_mname']?>">
                                    </div>
                                </div>
                                </div>

                                <div class="row justify-content-center" style="margin-top:40px;">
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label class="custom-label">Email address</label>
                                        <input name="surname" type="text" class="form-control" required="true" autocomplete="off" value=" <?php echo $_SESSION['email']?>"> 
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label class="custom-label">Contact no.</label>
                                        <input name="given_name" type="text" class="form-control" required="true" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label class="custom-label">User Id</label>
                                        <input name="middle_name" type="text" class="form-control" required="true" autocomplete="off" value=" <?php echo $_SESSION['repo_user_id']?>">
                                    </div>
                                </div>
                            </div>
                            </section>
                            
               


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