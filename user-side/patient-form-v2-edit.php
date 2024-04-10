    <?php
    include('../includes/config.php');

    session_start();

    //SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
    if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
        header("Location: ../login.php");
        exit; 
    }

    // Retrieve repo_user_id from session
    $repo_user_id = $_SESSION['repo_user_id'];

    // Retrieve hospital_id for the current user
    $query_hospital_id = "SELECT hospital_id FROM public.repo_user WHERE repo_user_id = $1";
    $result_hospital_id = pg_query_params($db_connection, $query_hospital_id, array($repo_user_id));

    if ($result_hospital_id) {
        $row_hospital_id = pg_fetch_assoc($result_hospital_id);
        $hospital_id = $row_hospital_id['hospital_id'];
    }

    // Check if patient_id is set in the URL
    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
        // Retrieve the patient_id from the URL
        $edit_patient_id = $_GET['edit'];

        // Query to fetch patient information using patient_id
        $query = "SELECT * FROM cancer_cases_general_info WHERE patient_id = $1";
        $result = pg_query_params($db_connection, $query, array($edit_patient_id));

        // Check if query was successful
        if ($result) {
            // Fetch patient information
            $patient_info = pg_fetch_assoc($result);
            if ($patient_info) {
                // Extract patient information
                $diagnosis_date = $patient_info['diagnosis_date'];
                $primary_site = $patient_info['primary_site'];
                $cancer_stage = $patient_info['cancer_stage'];
                $type_of_patient = $patient_info['type_of_patient'];
                $age = $patient_info['age'];
                $sex = $patient_info['sex'];
                $patient_status = $patient_info['patient_status'];
                $date_of_death = $patient_info['date_of_death'];
                $patient_case_number = $patient_info['patient_case_number'];
                $address_city_municipality = $patient_info['address_city_municipality'];
            } else {
                // Patient not found
                echo "Patient not found.";
            }
        } else {
            // Error in query
            echo "Error: " . pg_last_error($db_connection);
        }

        // Ang function ng code na to is to Fetch submitter information from the database
        $sql = "SELECT user_fname, user_lname, user_mname, position FROM repo_user WHERE repo_user_id = $1";
        $result = pg_query_params($db_connection, $sql, [$_SESSION['repo_user_id']]);

        //fetching user sa database
        $row = pg_fetch_assoc($result);
        if ($row) {
            //variables na needed para sa fetching para ilagay doon sa form
            $first_name = $row['user_fname'];
            $last_name = $row['user_lname'];
            $middle_name = $row['user_mname'];
            $designation = $row['position'];
        } else {
            // output kapag walang data
            echo "No user found with the specified ID.";
        }
    } else {
        // Redirect to an error page or display an error message
        echo "Error: Patient ID not found in URL.";
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $diagnosis_date = $_POST['diagnosis_date'];
        $primary_site = $_POST['primary_site'];
        $cancer_stage = $_POST['cancer_stage'];
        $type_of_patient = $_POST['patient_type'];
        $age = $_POST['age'];
        $sex = $_POST['gender'];
        $patient_status = $_POST['patient_status'];
        $date_of_death = ($_POST['patient_status'] == 'Dead') ? $_POST['date_of_death'] : NULL;
        $patient_case_number = $_POST['patient_case_number'];
        $address_city_municipality = $_POST['city'];

            // Query to update patient information in the database
            $update_query = "UPDATE cancer_cases_general_info SET diagnosis_date = $1, primary_site = $2, cancer_stage = $3, type_of_patient = $4, age = $5, sex = $6, patient_status = $7, date_of_death = $8, patient_case_number = $9, address_city_municipality = $10 WHERE patient_id = $11";

            // Prepare and execute the update query
            $update_result = pg_query_params($db_connection, $update_query, array($diagnosis_date, $primary_site, $cancer_stage, $type_of_patient, $age, $sex, $patient_status, $date_of_death, $patient_case_number, $address_city_municipality, $edit_patient_id));

            if ($update_result) {
                // Log the edit action
                $log_action = "Patient Details Updated";
                $query_log_success = "INSERT INTO public.repository_logs (log_timestamp, repo_user_id, patient_id, hospital_id, completed_by_lname, completed_by_fname, completed_by_mname, designation, patient_case_number, log_action) VALUES (timezone('Asia/Manila', current_timestamp), $1, $2, $3, $4, $5, $6, $7, $8, $9)";
                $result_log_success = pg_query_params($db_connection, $query_log_success, array($_SESSION['repo_user_id'], $edit_patient_id, $hospital_id, $last_name, $first_name, $middle_name, $designation, $patient_case_number, $log_action));

                if (!$result_log_success) {
                }
             }
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
    <title>PCC CANCER REPOSITORY</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="../profiles/pcc-logo1.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="../assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
    .page-header {
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        color: #fff;
    }

    .form-group {
        margin-bottom: 3.5rem;
    }

    .form-step {
        display: none;
    }

    .page-header .breadcrumb-item.active,
    .page-header .welcome h3 {
        color: #204A3D;
        font-size: 2rem;
        font-weight: 700;
    }

    .body-container {
        background-color: #FAFAFA;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    table {
        text-align: center;
        border: 1px solid #285D4D;
    }

    .page-title {
        font-size: 1.3rem;
        color: #204A3D;
        font-weight: 900;
    }

    .btn-blue {
        background-color: #0D6EFD;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        border: none;
        border-radius: 5px;
        width: 100%;
        border: 1px solid #9E9E9E;
        margin-bottom: 20px;
    }

    .search-input:focus {
        outline: none;
    }

    .search-container i {
        position: absolute;
        left: 15px;
        top: 45%;
        transform: translateY(-50%);
        color: #888;
    }

    .filter-btn {
        padding: 8px 20px;
        background-color: #E5F6F1;
        color: #204A3D;
        border: 1px solid #204A3D;
    }

    .add-btn {
        border-radius: 5px;
        padding: 8px 2rem;
    }

    .m-right {
        margin-right: -0.8rem;
    }

    .card-body {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 0.5rem;
    }

    textarea.form-control {
        height: 180px;
    }

    .custom-label {
        color: #204A3D;
        font-weight: 500;
    }
        /* Hide the spinner for number input */
        input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield; /* Firefox */
    }
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include("user-header.php"); ?>
        <?php include("user-sidebar.php"); ?>


        <div class="page-wrapper">
            <div class="containers">
            <form method="post" action="patient-form-v2-edit.php?edit=<?php echo htmlspecialchars($edit_patient_id, ENT_QUOTES, 'UTF-8'); ?>" id="registrationForm" enctype="multipart/form-data">
                    <div id="step1" class="form-step">
                        <div class="content container-fluid">

                            <!-- WELCOME MESSAGE -->
                            <div class="page-header">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="welcome d-flex justify-content-between align-items-center">
                                            <h3 class="page-title">General Patient Information</h3>

                                        </div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item active"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- METRICS -->
                            <div class="pd-20 card-box mb-30">

                                <div class="wizard-content">

                                    <section>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">Date of Diagnosis</label>
                                                    <div class="input-group date">
                                                        <input name="diagnosis_date" type="date" class="form-control date-picker" id="datepicker3" required="true" autocomplete="off" onchange="updateMinDeathDate()" value="<?php echo htmlspecialchars($diagnosis_date, ENT_QUOTES); ?>">
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Primary Site</label>
                                                    <select name="primary_site" class="custom-select form-control" required="true" autocomplete="off">
                                                        <option value="" disabled selected>Select Type</option>
                                                        <?php
                                                        // Array of primary site options
                                                        $primary_site_options = array(
                                                            "Brain", "Bladder", "Breast", "Colon", "Corpus-uteri", "Esophagus",
                                                            "Kidney", "Larynx", "Leukemia", "Liver", "Lung", "Skin", "Nasopharynx",
                                                            "Oral", "Ovary", "Prostate", "Rectum", "Stomach", "Testis", "Thyroid", "Uterine"
                                                        );

                                                        // Loop through the options and populate the select element
                                                        foreach ($primary_site_options as $site) {
                                                            // Check if the current site matches the patient's existing primary site
                                                            $selected = ($site == $patient_info['primary_site']) ? 'selected' : '';

                                                            // Output the option element
                                                            echo "<option value=\"$site\" $selected>$site</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Cancer Stage</label>
                                                    <select name="cancer_stage" class="custom-select form-control" required="true">
                                                        <option value="">Select Type</option>
                                                        <option value="1" <?php if ($cancer_stage == "1") echo "selected"; ?>>I</option>
                                                        <option value="2" <?php if ($cancer_stage == "2") echo "selected"; ?>>II</option>
                                                        <option value="3" <?php if ($cancer_stage == "3") echo "selected"; ?>>III</option>
                                                        <option value="4" <?php if ($cancer_stage == "4") echo "selected"; ?>>IV</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Type of Patient</label>
                                                    <select name="patient_type" class="custom-select form-control" required="true">
                                                        <option value="" disabled selected>Select Type</option> 
                                                        <option value="In-patient" <?php if ($type_of_patient == "In-patient") echo "selected"; ?>>In-patient</option>
                                                        <option value="Out-patient" <?php if ($type_of_patient == "Out-patient") echo "selected"; ?>>Out-patient</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="custom-label">Age</label>
                                                <input name="age" type="number" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label class="custom-label">Sex</label>
                                                <select name="gender" class="custom-select form-control" required="true">
                                                    <option value="">Select Sex</option>
                                                    <option value="Male" <?php if ($sex === 'Male') echo 'selected'; ?>>Male</option>
                                                    <option value="Female" <?php if ($sex === 'Female') echo 'selected'; ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Status</label>
                                                    <select name="patient_status" class="custom-select form-control" required="true" onchange="toggleDateOfDeath(this)">
                                                        <option value="" disabled>Select Status</option>
                                                        <option value="Alive" <?php if ($patient_status === 'Alive') echo 'selected'; ?>>Alive</option>
                                                        <option value="Survived" <?php if ($patient_status === 'Survived') echo 'selected'; ?>>Survived</option>
                                                        <option value="Dead" <?php if ($patient_status === 'Dead') echo 'selected'; ?>>Dead</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group" id="dateOfDeathField" <?php if ($patient_status == 'Dead') echo 'style="display: block;"'; ?>>
                                                    <label class="custom-label">Date of Death</label>
                                                    <div class="input-group date">
                                                        <input type="date" name="date_of_death" class="form-control date-picker" id="datepicker1" autocomplete="off" value="<?php echo htmlspecialchars($date_of_death); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">City/Municipality</label>
                                                    <input name="city" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo htmlspecialchars($address_city_municipality); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Case Number</label>
                                                    <input name="patient_case_number" type="text" class="form-control date-picker" required="true" autocomplete="off" value="<?php echo htmlspecialchars($patient_case_number); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="page-header">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="welcome d-flex justify-content-between align-items-center">
                                                                <h3 class="page-title">Submitter Information</h3>
                                                            </div>
                                                            <ul class="breadcrumb">
                                                                <li class="breadcrumb-item active"></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">Last Name</label>
                                                        <input name="last_name" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $last_name; ?>" readonly>                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">First Name</label>
                                                        <input name="first_name" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $first_name; ?>" readonly>                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">Middle Name</label>
                                                        <input name="sub_middle_name" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $middle_name; ?>" readonly>                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">Designation</label>
                                                        <input name="designation" type="text" class="form-control" required="true" autocomplete="off" value="<?php echo $designation; ?>" readonly>                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label style="font-size:16px;"><b></b></label>
                                                        <div class="">
                                                            <button class="btn btn-primary" name="submit" id="" data-toggle="modal" onclick="displaySuccessCredentialsAlert(event)">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
 
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
    <script>
        <?php
            // Check if the form is submitted successfully
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $update_result) {
                // Display success alert using SweetAlert
                echo "Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Patient details updated successfully.',
                    timer: 2000, // Duration for the alert to close automatically
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then((result) => {
                    // Redirect to manage-patient.php after the alert is closed
                    window.location.href = 'manage-patient.php';
                });";
            }
        ?>
    </script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
        });
        function toggleDateOfDeath(selectElement) {
        var dateOfDeathField = document.getElementById('dateOfDeathField');
        if (selectElement.value === 'Dead') {
            dateOfDeathField.style.display = 'block';
            document.getElementById('datepicker1').setAttribute('required', 'true');
        } else {
            dateOfDeathField.style.display = 'none';
            document.getElementById('datepicker1').removeAttribute('required');
        }
    }

    //DATE VALIDATION BETWEEM DIAGNONIS AND DEATH DATE
    function validateDates() {
        var diagnosisDate = new Date(document.getElementById('datepicker3').value);
        var deathDate = new Date(document.getElementById('datepicker1').value);

        if (deathDate < diagnosisDate) {
            displayError("Date of Death cannot be before Date of Diagnosis");
            return false;
        }
        return true;
    }

    // Function to update min attribute of Date of Death input
    function updateMinDeathDate() {
        var diagnosisDate = new Date(document.getElementById('datepicker3').value);
        document.getElementById('datepicker1').min = formatDate(diagnosisDate);
    }

    // Function to format date as YYYY-MM-DD
    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        return year + '-' + month + '-' + day;
    }
    </script>

    <script src="../assets/js/script.js"></script>
    <!-- jQuery -->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script>
    $(document).ready(function() {
        // Initialize first datepicker
        $("#datepicker1").datepicker();
        // Initialize second datepicker
        $("#datepicker2").datepicker();
        // Initialize third datepicker
        $("#datepicker3").datepicker();
        // Initialize fourth datepicker 
        $("#datepicker4").datepicker();
        // Initialize fifth datepicker
        $("#datepicker5").datepicker();




    });
    </script>




    <!-- jQuery -->
    <script src="../assets/js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="../assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="../assets/js/chart.js"></script>

    <!-- Select2 JS -->
    <script src="../assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="../assets/js/app.js"></script>
</body>

</html>