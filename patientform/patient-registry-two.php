<?php
    session_start();

    //SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
    if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
        header("Location: login.php");
        exit; 
    }

    error_reporting(0);
    include('./includes/config.php');


    //Session para sa patient_id, gagamitin para sa fk 
    $patient_id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : null;
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

                <form action="patient-registry-two-submit.php" method="post">
                    <div class="row form-rows">
                        <div class="col-md-3 radio-container">
                            <label>Smoking</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="smoking_no" name="smoking" value="false">
                                    <label for="smoking_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="smoking_yes" name="smoking" value="true">
                                    <label for="smoking_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Estimated number of years smoking</label>
                            <input type="number" name="estimate_years_smoking" id="estimate_years_smoking" value="" required>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Physical Activity</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="physical_activity_no" name="physical_activity" value="false">
                                    <label for="physical_activity_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="physical_activity_yes" name="physical_activity" value="true">
                                    <label for="physical_activity_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="row form-rows">
                            <div class="col-md-3 checkbox-container">
                                <label>Diet</label>
                                <div class="checkboxes">
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="diet_meat" name="diet" value="meat">
                                        <label for="diet_meat">Meat</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="diet_fruit" name="diet" value="fruit">
                                        <label for="diet_fruit">Fruit</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="diet_carbohydrates" name="diet" value="carbohydrates">
                                        <label for="diet_carbohydrates">Carbohydrates</label>
                                    </div>
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="diet_other" name="diet" value="other">
                                        <label for="diet_other">other</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-3 radio-container">
                            <label>Drinking of Alcohol</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="drinking_alcohol_no" name="drinking_alcohol" value="false">
                                    <label for="drinking_alcohol_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="drinking_alcohol_yes" name="drinking_alcohol" value="true">
                                    <label for="drinking_alcohol_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Estimate Number of Years Drinking</label>
                            <input type="number" name="estimate_years_alcohol" id="estimate_years_alcohol" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Number of Sexual-Partners</label>
                            <input type="number" name="no_of_sexual_partners" id="no_of_sexual_partners" value="" required>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Use of Contraceptives</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="contraceptives_no" name="use_of_contraceptive" value="false">
                                    <label for="contraceptives_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="contraceptives_yes" name="use_of_contraceptive" value="true">
                                    <label for="contraceptives_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Early Age Sexual Intercourse</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="early_age_sexual_intercourse_no" name="early_age_sexual_intercourse" value="false">
                                    <label for="early_age_sexual_intercourse_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="early_age_sexual_intercourse_yes" name="early_age_sexual_intercourse" value="true">
                                    <label for="early_age_sexual_intercourse_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Chemical Exposure</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="chemical_exposure_no" name="chemical_exposure" value="false">
                                    <label for="chemical_exposure_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="chemical_exposure_yes" name="chemical_exposure" value="true">
                                    <label for="chemical_exposure_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Family History/Cancer</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="family_history_no" name="family_history_with_cancer" value="false">
                                    <label for="family_history_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="family_history_yes" name="family_history_with_cancer" value="true">
                                    <label for="family_history_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Height</label>
                            <input type="number" name="height" id="height" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Weight</label>
                            <input type="number" name="weight" id="weight" value="">
                        </div>
                        <div class="col-md-3">
                            <label>BMI Classification</label>
                            <select name="classification_bmi" id="classification_bmi">
                                <option value="" disabled selected>Select Type</option>
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
                                    <input type="radio" id="human_papilloma_no" name="human_papillomavirus" value="false">
                                    <label for="human_papilloma_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="human_papilloma_yes" name="human_papillomavirus" value="true">
                                    <label for="human_papilloma_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Helicobacter Pylori Virus Infection</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="helicobacter_pylori_no" name="helicobacter_pylori_virus" value="false">
                                    <label for="helicobacter_pylori_no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="helicobacter_pylori_yes" name="helicobacter_pylori_virus" value="true">
                                    <label for="helicobacter_pylori_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Hepatitis B Virus</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="hepatitis_b_virus_no" name="hepatitis_b_virus" value="false">
                                    <label for="hepatitis_b_virus_yes">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="hepatitis_b_virus_yes" name="hepatitis_b_virus" value="true">
                                    <label for="hepatitis_b_virus_yes">Yes</label>
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
                                <!--<input type="button" name="" value="Next" onclick="redirectToThirdPage()">-->
                                <input type="submit" name="submit" value="Save">
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