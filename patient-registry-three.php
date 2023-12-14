<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="This is a Philippine Cancer Center HR Management System">
    <meta name="keywords" content="PCC-HRMS, HRMS, Human Resource, Capstone, System, HR">
    <meta name="author" content="Heionim">
    <meta name="robots" content="noindex, nofollow">
    <title>PCC HRMS</title>

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

        <?php include_once("includes/header.php"); ?>
        <?php include_once("includes/sidebar.php"); ?>

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

                <form action="" class="" method="post">

                    <div class="row form-rows">
                        <div class="col-md-3">
                            <label>Date of Consultation</label>
                            <input type="date" name="consultation-date" id="consultation-date" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Chief Complaint</label>
                            <input type="text" name="chief-complaint" id="chief-complaint" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Date of Diagnosis</label>
                            <input type="date" name="diagnosis-date" id="diagnosis-date" value="">
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
                            <!-- EMPTY -->
                        </div>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-md-3 radio-container">
                            <label>Brain</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="brain-no" name="brain" value="no">
                                    <label for="brain-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="brain-yes" name="brain" value="yes">
                                    <label for="brain-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 radio-container">
                            <label>Bladder</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="bladder-no" name="bladder" value="no">
                                    <label for="bladder-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="bladder-yes" name="bladder" value="yes">
                                    <label for="bladder-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 radio-container">
                            <label>Type of Bladder</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="type-of-bladder-no" name="type-of-bladder" value="no">
                                    <label for="type-of-bladder-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="type-of-bladder-yes" name="type-of-bladder" value="yes">
                                    <label for="type-of-bladder-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 radio-container">
                            <label>Breast</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="breast-no" name="breast" value="no">
                                    <label for="breast-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="breast-yes" name="breast" value="yes">
                                    <label for="breast-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Colon</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="colon-no" name="colon" value="no">
                                    <label for="colon-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="colon-yes" name="colon" value="yes">
                                    <label for="colon-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 radio-container">
                            <label>Corpus Uteri</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="corpus-uteri-no" name="corpus-uteri" value="no">
                                    <label for="corpus-uteri-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="corpus-uteri-yes" name="corpus-uteri" value="yes">
                                    <label for="corpus-uteri-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 radio-container">
                            <label>Esophagus</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="esophagus-no" name="esophagus" value="no">
                                    <label for="esophagus-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="esophagus-yes" name="esophagus" value="yes">
                                    <label for="esophagus-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 radio-container">
                            <label>Kidney</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="kidney-no" name="kidney" value="no">
                                    <label for="kidney-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="kidney-yes" name="kidney" value="yes">
                                    <label for="kidney-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 radio-container">
                            <label>Larynx</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="larynx-no" name="larynx" value="no">
                                    <label for="larynx-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="larynx-yes" name="larynx" value="yes">
                                    <label for="larynx-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 radio-container">
                            <label>Leukemia</label>
                            <div class="radios">
                                <div class="no-radio">
                                    <input type="radio" id="leukemia-no" name="leukemia" value="no">
                                    <label for="leukemia-no">No</label>
                                </div>
                                <div class="yes-radio">
                                    <input type="radio" id="leukemia-yes" name="leukemia" value="yes">
                                    <label for="leukemia-yes">Yes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Cancer Stage</label>
                            <input type="text" name="cancer-stage" id="cancer-stage" value="">
                        </div>
                        <div class="col-md-3">
                            <label>Final Diagnosis</label>
                            <textarea id="final-diagnosis" name="final-diagnosis"></textarea>
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