<?php

include('../includes/config.php');

session_start();
error_reporting(0);

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}
// Initializing ng hospital_name para sa banner
$hospital_name = $_SESSION['hospital_name'];




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
}


pg_close($db_connection);
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
            <form method="post" action="patient-form-v2-save.php" id="registrationForm" enctype="multipart/form-data">
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
                                                        <input name="diagnosis_date" type="date" class="form-control date-picker" id="diagnosis_date" autocomplete="off" onchange="updateMinDeathDate()" required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Primary Site</label>
                                                    <select name="primary_site" id="primary_site" class="custom-select form-control" autocomplete="off" required="true">
                                                        <option value="" disabled selected>Select Type</option>
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
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Cancer Stage</label>
                                                    <select name="cancer_stage" id="cancer_stage" class="custom-select form-control" required="true">
                                                        <option value="">Select Type</option>
                                                        <option value=1>I</option>
                                                        <option value=2>II</option>
                                                        <option value=3>III</option>
                                                        <option value=4>IV</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Type of Patient</label>
                                                    <select name="patient_type" id="patient_type" class="custom-select form-control" autocomplete="off" required="true">
                                                        <option value="" disabled selected>Select Type</option>
                                                        <option value="In-patient">In-patient</option>
                                                        <option value="Out-patient">Out-patient</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Age</label>
                                                    <input name="age" id="age" type="number" class="form-control" autocomplete="off" placeholder="Enter age" required="true">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Sex</label>
                                                    <select name="gender" id="gender" class="custom-select form-control" required="true">
                                                        <option value="">Select Sex</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Status</label>
                                                    <select name="patient_status" id="patient_status" class="custom-select form-control" onchange="toggleDateOfDeath(this)" required="true">
                                                        <option value="" disabled selected>Select Status</option>
                                                        <option value="Alive">Alive</option>
                                                        <option value="Survived">Survived</option>
                                                        <option value="Dead">Dead</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group" id="dateOfDeathField" style="display: none;">
                                                    <label class="custom-label">Date of Death</label>
                                                    <div class="input-group date">
                                                    <input type="date" name="date_of_death" id="date_of_death" class="form-control date-picker" autocomplete="off" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">City/Municipality</label>
                                                    <select name="city" id="city" class="custom-select form-control" required="true">
                                                        <option value="" disabled selected>Select City/Municipality</option>
                                                        <option value="Alaminos">Alaminos</option>
                                                        <option value="Angeles">Angeles</option>
                                                        <option value="Antipolo">Antipolo</option>
                                                        <option value="Bacolod">Bacolod</option>
                                                        <option value="Bacoor">Bacoor</option>
                                                        <option value="Bago">Bago </option>
                                                        <option value="Baguio">Baguio </option>
                                                        <option value="Bais">Bais </option>
                                                        <option value="Balanga">Balanga </option>
                                                        <option value="Baliwag">Baliwag </option>
                                                        <option value="Batac">Batac</option>
                                                        <option value="Batangas">Batangas </option>
                                                        <option value="Bayawan">Bayawan </option>
                                                        <option value="Baybay">Baybay </option>
                                                        <option value="Bayugan">Bayugan </option>
                                                        <option value="Biñan">Biñan </option>
                                                        <option value="Bislig">Bislig </option>
                                                        <option value="Bogo">Bogo </option>
                                                        <option value="Borongan">Borongan </option>
                                                        <option value="Butuan">Butuan </option>
                                                        <option value="Cabadbaran">Cabadbaran </option>
                                                        <option value="Cabanatuan">Cabanatuan </option>
                                                        <option value="Cabuyao">Cabuyao </option>
                                                        <option value="Cadiz">Cadiz </option>
                                                        <option value="Cagayande Oro">Cagayande Oro </option>
                                                        <option value="Calaca">Calaca </option>
                                                        <option value="Calamba">Calamba </option>
                                                        <option value="Calapan">Calapan </option>
                                                        <option value="Calbayog">Calbayog</option>
                                                        <option value="Caloocan">Caloocan </option>
                                                        <option value="Candon">Candon </option>
                                                        <option value="Canlaon">Canlaon </option>
                                                        <option value="Carcar">Carcar </option>
                                                        <option value="Catbalogan">Catbalogan </option>
                                                        <option value="Cauayan">Cauayan </option>
                                                        <option value="Cavite">Cavite </option>
                                                        <option value="Cebu">Cebu </option>
                                                        <option value="Cotabato">Cotabato </option>
                                                        <option value="Dagupan">Dagupan </option>
                                                        <option value="Danao">Danao </option>
                                                        <option value="Dapitan">Dapitan </option>
                                                        <option value="Dasmariñas">Dasmariñas </option>
                                                        <option value="Davao">Davao </option>
                                                        <option value="Digos">Digos </option>
                                                        <option value="Dipolog">Dipolog </option>
                                                        <option value="Dumaguete">Dumaguete </option>
                                                        <option value="El Salvador">El Salvador </option>
                                                        <option value="Escalante">Escalante </option>
                                                        <option value="Gapan">Gapan </option>
                                                        <option value="General Santos">General Santos </option>
                                                        <option value="General Trias">General Trias </option>
                                                        <option value="Gingoog">Gingoog</option>
                                                        <option value="Guihulngan">Guihulngan</option>
                                                        <option value="Himamaylan">Himamaylan </option>
                                                        <option value="Ilagan">Ilagan</option>
                                                        <option value="Iligan">Iligan </option>
                                                        <option value="Iloilo">Iloilo </option>
                                                        <option value="Imus">Imus </option>
                                                        <option value="Iriga">Iriga </option>
                                                        <option value="Isabela">Isabela </option>
                                                        <option value="Kabankalan">Kabankalan </option>
                                                        <option value="Kidapawan">Kidapawan </option>
                                                        <option value="Koronadal">Koronadal </option>
                                                        <option value="La Carlota">La Carlota </option>
                                                        <option value="Lamitan">Lamitan </option>
                                                        <option value="Lapu-Lapu">Lapu-Lapu </option>
                                                        <option value="Las Piñas">Las Piñas </option>
                                                        <option value="Legazpi">Legazpi </option>
                                                        <option value="Ligao">Ligao </option>
                                                        <option value="Lipa">Lipa </option>
                                                        <option value="Lucena">Lucena </option>
                                                        <option value="Maasin">Maasin</option>
                                                        <option value="Mabalacat">Mabalacat</option>
                                                        <option value="Makati">Makati</option>
                                                        <option value="Malaybalay">Malaybalay</option>
                                                        <option value="Malolos">Malolos</option>
                                                        <option value="Mandaluyong">Mandaluyong</option>
                                                        <option value="Mandaue">Mandaue</option>
                                                        <option value="Manila">Manila</option>
                                                        <option value="Marawi">Marawi</option>
                                                        <option value="Marikina">Marikina</option>
                                                        <option value="Masbate">Masbate</option>
                                                        <option value="Mati">Mati</option>
                                                        <option value="Meycauayan">Meycauayan</option>
                                                        <option value="Muñoz">Muñoz</option>
                                                        <option value="Muntinlupa">Muntinlupa</option>
                                                        <option value="Naga">Naga</option>
                                                        <option value="Navotas">Navotas</option>
                                                        <option value="Olongapo">Olongapo</option>
                                                        <option value="Ormoc">Ormoc</option>
                                                        <option value="Oroquieta">Oroquieta</option>
                                                        <option value="Ozamiz">Ozamiz</option>
                                                        <option value="Pagadian">Pagadian</option>
                                                        <option value="Palayan">Palayan</option>
                                                        <option value="Panabo">Panabo</option>
                                                        <option value="Parañaque">Parañaque</option>
                                                        <option value="Pasay">Pasay</option>
                                                        <option value="Pasig">Pasig</option>
                                                        <option value="Passi">Passi</option>
                                                        <option value="Puerto Princesa">Puerto Princesa</option>
                                                        <option value="Quezon City">Quezon City</option>
                                                        <option value="San Carlos">San Carlos</option>
                                                        <option value="SanFernando">SanFernando</option>
                                                        <option value="Samal">Samal</option>
                                                        <option value="San Jose">San Jose</option>
                                                        <option value="San Jose del Monte">San Jose del Monte</option>
                                                        <option value="San Juan">San Juan</option>
                                                        <option value="San Pablo">San Pablo</option>
                                                        <option value="San Pedro">San Pedro</option>
                                                        <option value="Santa Rosa">Santa Rosa</option>
                                                        <option value="Santo Tomas">Santo Tomas</option>
                                                        <option value="Santiago">Santiago</option>
                                                        <option value="Silay">Silay</option>
                                                        <option value="Sipalay">Sipalay</option>
                                                        <option value="Sorsogon">Sorsogon</option>
                                                        <option value="Surigao">Surigao</option>
                                                        <option value="Tabaco">Tabaco</option>
                                                        <option value="Tabuk">Tabuk</option>
                                                        <option value="Tacloban">Tacloban</option>
                                                        <option value="Tacurong">Tacurong</option>
                                                        <option value="Tagaytay">Tagaytay</option>
                                                        <option value="Tagbilaran">Tagbilaran</option>
                                                        <option value="Taguig">Taguig</option>
                                                        <option value="Tagum">Tagum</option>
                                                        <option value="Talisay">Talisay</option>
                                                        <option value="Tanauan">Tanauan</option>
                                                        <option value="Tandag">Tandag</option>
                                                        <option value="Tangub">Tangub</option>
                                                        <option value="Tanjay">Tanjay</option>
                                                        <option value="Tarlac">Tarlac</option>
                                                        <option value="Tayabas">Tayabas</option>                                    
                                                        <option value="Toledo">Toledo</option>
                                                        <option value="Trece Martires">Trece Martires</option>
                                                        <option value="Tuguegarao">Tuguegarao</option>
                                                        <option value="Urdaneta">Urdaneta</option>
                                                        <option value="Valencia">Valencia</option>
                                                        <option value="Valenzuela">Valenzuela</option>
                                                        <option value="Victorias">Victorias</option>
                                                        <option value="Vigan">Vigan</option>
                                                        <option value="Zamboanga">Zamboanga</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                        <label class="custom-label">Patient Case Number</label>
                                                        <input name="patient_case_number" id="patient_case_number" type="text" class="form-control date-picker" autocomplete="off" placeholder="Patient Case Number" required="true">
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
                                                        <input name="last_name" type="text" class="form-control" autocomplete="off" value="<?php echo $last_name; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">First Name</label>
                                                        <input name="first_name" type="text" class="form-control" autocomplete="off" value="<?php echo $first_name; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">Middle Name</label>
                                                        <input name="sub_middle_name" type="text" class="form-control" autocomplete="off" value="<?php echo $middle_name; ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="custom-label">Designation</label>
                                                        <input name="designation" type="text" class="form-control" autocomplete="off" value="<?php echo $designation; ?>" readonly>
                                                    </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        if (isset($_SESSION['insertion_success'])) {
            if ($_SESSION['insertion_success']) {
                echo "displaySuccessCredentialsAlert();";
            } else {
                echo "displayErrorAlert();";
            }

            // Clear the session variable
            unset($_SESSION['insertion_success']);
        }
        ?>

        function displaySuccessCredentialsAlert() {
            Swal.fire({
                title: 'Success!',
                text: 'Data inserted successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }

        function displayErrorAlert() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to insert data.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (isset($_SESSION['already-sent'])) {
                $success = $_SESSION['already-sent'];
                // Clear the session error variable
                unset($_SESSION['already-sent']);

                // Display the error for incorrect password
                echo "displaySuccessCredentialsAlert('$success');";
            }
            ?>


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