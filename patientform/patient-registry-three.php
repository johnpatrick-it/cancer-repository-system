<?php
    session_start();

    //SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
    if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
        header("Location: login.php");
        exit; 
    }

    error_reporting(0);
    include('./includes/config.php');


    //Session para sa patient_id, gagamitin para sa fk(important)
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
            padding: 5em 4rem 0;
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

        .row {
            margin-bottom: 1rem;
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

        /* TEXTAREA */
        .col-md-3 textarea {
            width: 300px;
            height: 150px;
            resize: none;
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
                        <h2 id="info-txt">Cancer Data</h2>
                    </div>

                    <div class="col-md-8">
                        <!-- EMPTY -->
                    </div>
                    <hr>
                </div>

                <form action="patient-registry-three-submit.php" class="" method="post">

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
                            <select name="valid_diagnosis_non_microscopic" id="valid_diagnosis_non_microscopic" required>
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
                            <select name="valid_diagnosis_microscopic" id="valid_diagnosis_microscopic" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="N/A">N/A</option>
                                <option value="cytology_hematology">Cytology Hematology</option>
                                <option value="	histology_of_metastatis">Histology of Metastatis</option>
                                <option value="histology_of_primary">Histology of Primary</option>
                            </select>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Multiple Primaries</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="multiple_primaries-no" name="multiple_primaries" value="false">
                                    <label for="multiple_primaries-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="multiple_primaries-yes" name="multiple_primaries" value="true">
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
                                <option value=""disabled selected>Select Type</option>
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
                                    <option value=""disabled selected>Select Type</option>
                                    <option value="Treatment-surgery">Surgery</option>
                                    <option value="Treatment-chemotherapy">Chemotherapy</option>
                                    <option value="Treatment-immunotherapy">Immunotherapy</option>
                                    <option value="Treatment-others">Others</option>
                                </select>
                        </div>
                        <div>
                            <label>Patient Status</label>
                            <select name="patient_status" id="patient_status">
                                <option value=""disabled selected>Select Type</option>
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
                                <input type="submit" name="submit" value="Save">
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

    <script>
        function confirmSubmission() {
            var confirmation = confirm("Are you sure that the information details are correct? Before you update the information");
            return confirmation;
        }
    </script>
</body>

</html>