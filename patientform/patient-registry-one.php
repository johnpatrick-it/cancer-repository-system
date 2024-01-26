<?php
session_start();

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}
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

        <?php include_once("./includes/user-header.php"); ?>
        <?php include_once("./includes/user-sidebar.php"); ?>

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

                <form action="patient-registry-one-submit.php" method="post">
                    <div class="row form-rows">
                        <div class="col-md-3">
                            <label>Type of Patient</label>
                            <select name="type_of_patient" id="type_of_patient" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="Out-patient">Out-patient</option>
                                <option value="In-patient">In-patient</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Surname</label>
                            <input type="text" name="patient_lname_initial" id="patient_lname_initial" value="" required>
                        </div>
                        <div class="col-md-3">
                            <label>Given name</label>
                            <input type="text" name="patient_fname_initial" id="patient_fname_initial" value="" required>
                        </div>
                        <div class="col-md-3">
                            <label>Middle name(Optional)</label>
                            <input type="text" name="patient_mname" id="patient_mname" value="" required>
                        </div>
                        <div class="col-md-3">
                            <label>Suffix</label>
                            <input type="text" name="patient_suffix" id="patient_suffix" value="" required>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Gender</label>
                                <select name="sex" id="sex" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Civil Status</label>
                                <select name="civil_status" id="civil_status" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorce</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Birth Date</label>
                                <input type="date" name="birthday" id="birthday" value="" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label>Permanent Address</label>
                                <input type="text" name="address_region" id="address_region" value="" required>
                            </div>
                            <div class="col-md-3">
                                <label>Barangay</label>
                                <input type="text" name="address_barangay" id="address_barangay" value="" required>
                            </div>
                            <div class="col-md-3">
                                <label>Province</label>
                                <input type="text" name="address_province" id="address_province" value="" required>
                            </div>
                            <div class="col-md-3">
                                <label>City/Municipality</label>
                                <input type="text" name="address_city_municipality" id="address_city_municipality" value="" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <label>Nationality</label>
                                <input type="text" name="nationality" id="nationality" value="" required>
                            </div>
                            <div class="col-md-3">
                                <label>Occupation</label>
                                <input type="text" name="occupation" id="occupation" value="" required>
                            </div>
                            <div class="col-md-3">
                                <label>Educational Attainment</label>
                                <input type="text" name="educational_attainment" id="educational_attainment" value="" required>
                            </div>
                            <div class="col-md-3">
                                <label>Race</label>
                                <input type="text" name="race" id="race" value="" required>
                            </div>
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
                                <!--<input type="submit" name="submit" value="Next">-->
                                <!--<input type="button" name="" value="Next" onclick="redirectToEditPatientPage()">-->
                                <input type="submit" name="submit" value="Save">
                                <div class="col-md-3">
                        </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

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
