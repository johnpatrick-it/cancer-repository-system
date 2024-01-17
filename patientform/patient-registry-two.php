<?php
session_start();

if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    // Redirect to the login page
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
            width: 80%;
            margin-bottom: 3rem;
        }

        .form-rows {
            margin-top: 3rem;
        }

        .next-btn input {
            background-color: #204A31E5;
            color: white;
            font-weight: bold;
            border: none;
            margin-top: 30px;
            padding: 10px;
            width: 60%;
            box-shadow: 0px 4px 4px 0px #0000004D;
        }

        .back-btn input {
            background-color: #F2F2F2;
            color: #204A31;
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


        /* RADIOS */
        .radio-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .radios {
            display: flex;
            justify-content: space-between;
            width: 30%;
        }

        .no-radio,
        .yes-radio {
            display: flex;
            justify-content: space-between;
            padding-right: 1rem
        }

        .no-radio input,
        .yes-radio input {
            margin-right: 1rem;
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

                <form action="" class="" method="post">

                    <div class="row form-rows">
                        <div class="col-md-3 radio-container">
                            <label>Smoking</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="smoking-no" name="smoking" value="no">
                                    <label for="smoking-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="smoking-yes" name="smoking" value="yes">
                                    <label for="smoking-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>No. of years smoking</label>
                            <input type="text" name="years-smoking" id="years-smoking" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Year started smoking</label>
                            <input type="text" name="started-smoking" id="started-smoking" value="">
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Physical Activity</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="physical-activity-no" name="physical-activity" value="no">
                                    <label for="physical-activity-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="physical-activity-yes" name="physical-activity" value="yes">
                                    <label for="physical-activity-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 radio-container">
                            <label>Drinking of Alcohol</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="drinking-alcohol-no" name="drinking-alcohol" value="no">
                                    <label for="drinking-alcohol-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="drinking-alcohol-yes" name="drinking-alcohol" value="yes">
                                    <label for="drinking-alcohol-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>No. of years drinking</label>
                            <input type="text" name="years-drinking" id="years-drinking" value="">
                        </div>
                        <div class="col-md-3">
                            <label>No. of sexual-partners</label>
                            <input type="text" name="sexual-partners" id="sexual-partners" value="">
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Use of Contraceptives</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="contraceptives-no" name="contraceptives" value="no">
                                    <label for="contraceptives-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="contraceptives-yes" name="contraceptives" value="yes">
                                    <label for="contraceptives-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Chemical Exposure</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="chemical-exposure-no" name="chemical-exposure" value="no">
                                    <label for="chemical-exposure-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="chemical-exposure-yes" name="chemical-exposure" value="yes">
                                    <label for="chemical-exposure-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Family History/Cancer</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="family-history-no" name="family-history" value="no">
                                    <label for="family-history-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="family-history-yes" name="family-history" value="yes">
                                    <label for="family-history-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Height</label>
                            <input type="text" name="height" id="height" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Weight</label>
                            <input type="text" name="weight" id="weight" value="">
                        </div>
                        <div class="col-md-3">
                            <label>BMI Classification</label>
                            <select name="bmi" id="bmi">
                                <option value=""></option>
                                <option value="Under-weight">Under-weight</option>
                                <option value="Normal">Normal</option>
                                <option value="Over-weight">Over-weight</option>
                                <option value="Obese">Obese</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 radio-container">
                            <label>Human Papilloma Virus Infection</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="human-papilloma-no" name="human-papilloma" value="no">
                                    <label for="human-papilloma-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="human-papilloma-yes" name="human-papilloma" value="yes">
                                    <label for="human-papilloma-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Helicobacter Pylori Virus Infection</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="helicobacter-pylori-no" name="helicobacter-pylori" value="no">
                                    <label for="helicobacter-pylori-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="helicobacter-pylori-yes" name="helicobacter-pylori" value="yes">
                                    <label for="helicobacter-pylori-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Helicobacter Pylori Virus Infection</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="helicobacter-pylorii-no" name="helicobacter-pylorii" value="no">
                                    <label for="helicobacter-pylorii-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="helicobacter-pylorii-yes" name="helicobacter-pylorii" value="yes">
                                    <label for="helicobacter-pylorii-yes">Yes</label>
                                </div>
                            </div>
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
                            <div class="back-btn">
                                <input type="button" name="" value="Back" onclick="redirectToFirstPage()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="next-btn">
                                <!-- <input type="submit" name="submit" value="Next"> -->
                                <input type="button" name="" value="Next" onclick="redirectToThirdPage()">
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- FOR STATIC REDIRECT -->
    <script>
        function redirectToFirstPage() {
            window.location.href = 'patient-registry-one.php';
        }

        function redirectToSecondPage() {
            window.location.href = 'patient-registry-two.php';
        }

        function redirectToThirdPage() {
            window.location.href = 'patient-registry-three.php';
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