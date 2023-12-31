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
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">

    <!-- Chart CSS -->
    <link rel="stylesheet" href="assets/plugins/morris/morris.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <style>
        .page-wrapper {
            padding: 4em;
        }

        hr {
            width: 100%;
        }

        input,
        select {
            color: #204A3D;
            border-radius: 5px;
            border: 1px solid #285D4D;
            outline: none;
            padding: 8px;
            font-size: 14px;
            width: 100%;
            margin-bottom: 3rem;
        }

        .form-rows {
            margin-top: 3rem;
        }

        .submit-btn input {
            background-color: #204A31E5;
            color: white;
            font-weight: bold;
            border: none;
            margin-top: 30px;
            padding: 10px;
            width: 60%;
            box-shadow: 0px 4px 4px 0px #0000004D;
        }

        .upload-button {
            background-color: #204A3D;
            color: #FAFAFA;
        }

        .upload-button:hover {
            background-color: #204A3D;
            color: white;
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <?php include_once("includes/user-header.php"); ?>
        <?php include_once("includes/user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="row">
                    <div class="col-md-4">
                        <h2 id="info-txt">General Patient Information</h2>
                    </div>

                    <div class="col-md-2">
                        <!-- EMPTY -->
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-auto ml-auto m-right">
                                <a href="#" class="btn upload-button" data-toggle="modal" data-target="#">
                                    <i class="fa fa-medkit"></i> Upload CSV File
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <form action="" class="" method="post">

                    <div class="row form-rows">
                        <div class="col-md-3">
                            <label>Surname</label>
                            <input type="text" name="surname" id="surname" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Given name</label>
                            <input type="text" name="given-name" id="given-name" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Middle name (Optional)</label>
                            <input type="text" name="middle-name" id="middle-name" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Suffix</label>
                            <input type="text" name="suffix" id="suffix" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Gender</label>
                            <input type="text" name="gender" id="gender" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Civil Status</label>
                            <select name="civil-status" id="civil-status">
                                <option value="test">TEST</option>
                                <option value="test">TEST</option>
                                <option value="test">TEST</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Birth Date</label>
                            <input type="date" name="birth-date" id="birth-date" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Place of Birth</label>
                            <input type="text" name="birth-place" id="birth-place" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Permanent Address</label>
                            <input type="text" name="address" id="address" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Barangay</label>
                            <input type="text" name="barangay" id="barangay" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Province</label>
                            <input type="text" name="province" id="province" value="">
                        </div>
                        <div class="col-md-3">
                            <label>City/Municipality</label>
                            <input type="text" name="city" id="city" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Contact Number</label>
                            <input type="text" name="firstname" id="firstname" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Nationality</label>
                            <input type="text" name="nationality" id="nationality" value="">
                        </div>
                        <div class="col-md-3">
                            <!-- BLANK -->
                        </div>
                        <div class="col-md-3">
                            <!-- BLANK -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <!-- BLANK -->
                        </div>
                        <div class="col-md-3">
                            <!-- BLANK -->
                        </div>
                        <div class="col-md-3">
                            <!-- BLANK -->
                        </div>
                        <div class="col-md-3">
                            <div class="submit-btn">
                                <!-- <input type="submit" name="submit" value="Next"> -->
                                <input type="button" name="" value="Next" onclick="redirectToEditPatientPage()">
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- FOR STATIC REDIRECT -->
    <script>
        function redirectToEditPatientPage() {
            window.location.href = 'patient-registry-two.php';
        }
    </script>

    <script src="assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/chart.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/app.js"></script>
</body>

</html>