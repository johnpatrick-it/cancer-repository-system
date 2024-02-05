<?php
session_start();

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}
error_reporting(0);
include_once("../includes/config.php");
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

    .submit-btn input,
    button {
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

    .form-step {
        display: none;
    }

    .form-step h2 {
        color: #333;
    }
    </style>
</head>

<body>
    <div class="container">
        <form id="registrationForm" action="process.php" method="post">
            <div id="step1" class="form-step">
                
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
                                        <button type="button" class="nextButton">Next</button>
                                        <div class="col-md-3">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            <!-- 2222222222222222222222222222222222222222222222222222222222222222222222222222222222222222 -->
            <div id="step2" class="form-step">
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


                                <hr>
                            </div>


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
                                    <input type="number" name="estimate_years_smoking" id="estimate_years_smoking"
                                        value="" required>
                                </div>
                                <div class="col-md-3 radio-container">
                                    <label>Physical Activity</label>
                                    <div class="radios">
                                        <div class="no-radio">
                                            <input type="radio" id="physical_activity_no" name="physical_activity"
                                                value="false">
                                            <label for="physical_activity_no">No</label>
                                        </div>
                                        <div class="yes-radio">
                                            <input type="radio" id="physical_activity_yes" name="physical_activity"
                                                value="true">
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
                                                <input type="checkbox" id="diet_carbohydrates" name="diet"
                                                    value="carbohydrates">
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
                                                <input type="radio" id="drinking_alcohol_no" name="drinking_alcohol"
                                                    value="false">
                                                <label for="drinking_alcohol_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="drinking_alcohol_yes" name="drinking_alcohol"
                                                    value="true">
                                                <label for="drinking_alcohol_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Estimate Number of Years Drinking</label>
                                        <input type="number" name="estimate_years_alcohol" id="estimate_years_alcohol"
                                            value="">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Number of Sexual-Partners</label>
                                        <input type="number" name="no_of_sexual_partners" id="no_of_sexual_partners"
                                            value="" required>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Use of Contraceptives</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="contraceptives_no" name="use_of_contraceptive"
                                                    value="false">
                                                <label for="contraceptives_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="contraceptives_yes" name="use_of_contraceptive"
                                                    value="true">
                                                <label for="contraceptives_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Early Age Sexual Intercourse</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="early_age_sexual_intercourse_no"
                                                    name="early_age_sexual_intercourse" value="false">
                                                <label for="early_age_sexual_intercourse_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="early_age_sexual_intercourse_yes"
                                                    name="early_age_sexual_intercourse" value="true">
                                                <label for="early_age_sexual_intercourse_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Chemical Exposure</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="chemical_exposure_no" name="chemical_exposure"
                                                    value="false">
                                                <label for="chemical_exposure_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="chemical_exposure_yes" name="chemical_exposure"
                                                    value="true">
                                                <label for="chemical_exposure_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Family History/Cancer</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="family_history_no"
                                                    name="family_history_with_cancer" value="false">
                                                <label for="family_history_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="family_history_yes"
                                                    name="family_history_with_cancer" value="true">
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
                                                <input type="radio" id="human_papilloma_no" name="human_papillomavirus"
                                                    value="false">
                                                <label for="human_papilloma_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="human_papilloma_yes" name="human_papillomavirus"
                                                    value="true">
                                                <label for="human_papilloma_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Helicobacter Pylori Virus Infection</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="helicobacter_pylori_no"
                                                    name="helicobacter_pylori_virus" value="false">
                                                <label for="helicobacter_pylori_no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="helicobacter_pylori_yes"
                                                    name="helicobacter_pylori_virus" value="true">
                                                <label for="helicobacter_pylori_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Hepatitis B Virus</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="hepatitis_b_virus_no" name="hepatitis_b_virus"
                                                    value="false">
                                                <label for="hepatitis_b_virus_yes">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="hepatitis_b_virus_yes" name="hepatitis_b_virus"
                                                    value="true">
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
                                            <button type="button" class="nextButton">Next</button>

                                            <button type="button" class="prevButton">Previous</button>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- 333333333333333333333333333333333333333333333333333333333333333333333-->
            <div id="step3" class="form-step">
                <div class="main-wrapper">

                    <?php include_once("./includes/user-header.php"); ?>
                    <?php include_once("./includes/user-sidebar.php"); ?>

                    <div class="page-wrapper">
                        <div class="content container-fluid">

                            <div class="row">
                                <div class="col-md-4">
                                    <h2 id="info-txt">Cancer Data</h2>
                                </div>

                                <div class="col-md-8">
                                    <!-- EMPTY -->
                                </div>
                                <hr>
                            </div>



                            <div class="row form-rows">
                                <div class="col-md-3">
                                    <label>Date of Consultation</label>
                                    <input type="date" name="consultation_date" id="consultation_date" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Date of Diagnosis</label>
                                    <input type="date" name="diagnosis_date" id="diagnosis_date" value="">
                                </div>

                                <div class="col-md-3">
                                    <!-- BLANK -->
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-4">
                                    <h2 id="info-txt">Primary Site</h2>
                                </div>

                                <div class="col-md-8">

                                </div>
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-md-3 radio-container">
                                    <div class="col-md-3">
                                        <label>Valid Diagnosis Non-microscopic</label>
                                        <select name="valid_diagnosis_non_microscopic"
                                            id="valid_diagnosis_non_microscopic" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="N/A">N/A</option>
                                            <option value="death_certificate">Death Certificate</option>
                                            <option value="	clinical_investigation">Clinical Investigation</option>
                                            <option value="clinical_only">Clinical Only</option>
                                            <option value="specific_tumor_markers">Specific Tumor Markers</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Valid Diagnosis Microscopic</label>
                                        <select name="valid_diagnosis_microscopic" id="valid_diagnosis_microscopic"
                                            required>
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="N/A">N/A</option>
                                            <option value="cytology_hematology">Cytology Hematology</option>
                                            <option value="	histology_of_metastatis">Histology of Metastatis
                                            </option>
                                            <option value="histology_of_primary">Histology of Primary</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Multiple Primaries</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="multiple_primaries-no" name="multiple_primaries"
                                                    value="false">
                                                <label for="multiple_primaries-no">No</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="multiple_primaries-yes"
                                                    name="multiple_primaries" value="true">
                                                <label for="multiple_primaries-yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Primary Site</label>
                                        <select name="primary_site" id="primary_site" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="N/A">N/A</option>
                                            <option value="Brain">Brain</option>
                                            <option value="Bladder">Bladder</option>
                                            <option value="Breast">Breast</option>
                                            <option value="Colon">Colon</option>
                                            <option value="Corpus-uteri">Corpus-uteri</option>
                                            <option value="Esophagus">Esophagus</option>
                                            <option value="Kidney">Kidney</option>
                                            <option value="Larynx">Larynx</option>
                                            <option value="Leukemia">Leukemia</option>
                                            <option value="Liver">Liver</option>
                                            <option value="Lung">Lung</option>
                                            <option value="Skin">Skin</option>
                                            <option value="Nasopharynx">Nasopharynx</option>
                                            <option value="Oral">Oral</option>
                                            <option value="Ovary">Ovary</option>
                                            <option value="Prostate">Prostate</option>
                                            <option value="Rectum">Rectum</option>
                                            <option value="Stomach">Stomach</option>
                                            <option value="Testis">Testis</option>
                                            <option value="Thyroid">Thyroid</option>
                                            <option value="Uterine">Uterine</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Others Primary site</label>
                                        <input type="text" name="primary_site_others" id="primary_site_others" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Tumor Size</label>
                                        <input type="number" name="tumor_size" id="tumor_size" value="">
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Nodes</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="nodes-no" name="nodes" value="false">
                                                <label for="nodes-no">Negative</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="nodes-yes" name="nodes" value="true">
                                                <label for="nodes-yes">Positive</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 radio-container">
                                        <label>Metastatis</label>
                                        <div class="radios">
                                            <div class="no-radio">
                                                <input type="radio" id="metastasis-no" name="metastasis" value="false">
                                                <label for="metastasis-no">Absent</label>
                                            </div>
                                            <div class="yes-radio">
                                                <input type="radio" id="metastasis-yes" name="metastasis" value="true">
                                                <label for="metastasis-yes">Present</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Cancer Stage</label>
                                        <select name="cancer_stage" id="cancer_stage">
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Final Diagnosis</label>
                                        <textarea id="final_diagnosis" name="final_diagnosis"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <label>Patient Treatment</label>
                                    <select name="patient_treatment" id="patient_treatment">
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Treatment-surgery">Surgery</option>
                                        <option value="Treatment-chemotherapy">Chemotherapy</option>
                                        <option value="Treatment-immunotherapy">Immunotherapy</option>
                                        <option value="Treatment-others">Others</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Patient Status</label>
                                    <select name="patient_status" id="patient_status">
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Alive">Alive</option>
                                        <option value="Disposition">Disposition</option>
                                        <option value="Dead">Dead</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Cause of Death</label>
                                    <input type="text" name="cause_of_death" id="cause_of_death" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Cause of Death</label>
                                    <input type="text" name="place_of_death" id="place_of_death" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Date of Death</label>
                                    <input type="date" name="date_of_death" id="date_of_death" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Transferred Hospital</label>
                                    <input type="text" name="transferred_hospital" id="transferred_hospital" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Reason for Referral</label>
                                    <input type="text" name="reason_for_referral" id="reason_for_referral" value="">
                                </div>

                                <div class="col-md-3">
                                    <!-- BLANK -->
                                </div>

                                <div class="col-md-4">
                                    <h2 id="info-txt">Submitter Information</h2>
                                </div>
                                <div class="col-md-3">
                                    <label>Last Name</label>
                                    <input type="text" name="completed_by_lname" id="completed_by_lname" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>First Name</label>
                                    <input type="text" name="completed_by_fname" id="completed_by_fname" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Middle Name</label>
                                    <input type="text" name="completed_by_mname" id="completed_by_mname" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Disignation</label>
                                    <input type="text" name="designation" id="designation" value="">
                                </div>
                                <div class="col-md-3">
                                    <label>Date of data inserted</label>
                                    <input type="date" name="date_completed" id="date_completed" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                    <button type="button" class="prevButton">Previous</button>

                                    <button type="submit">Submit</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

    </div>

    </form>
    </div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>


    <script src="../assets/js/script.js"></script>

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