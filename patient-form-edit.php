<?php

include('./includes/config.php');

session_start();

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}

$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";

try {
    $dbh = new PDO("pgsql:" . $host);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
<?php $get_id = $_GET['edit']; 
$_SESSION['edit_id'] = $_GET['edit'];?>




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
    <link rel="shortcut icon" type="image/x-icon" href="./profiles/pcc-logo1.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="./assets/css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="./assets/css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="./assets/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="./assets/css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">


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
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include("./includes/user-header.php"); ?>
        <?php include("./includes/user-sidebar.php"); ?>


        <div class="page-wrapper">
            <div class="containers">
                <form method="post" action="update_patient.php" id="registrationForm" enctype="multipart/form-data">
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
                                        <?php
								$query = $dbh->query("SELECT * FROM patient_general_info WHERE patient_id = '$get_id'");
								$row = $query->fetch(PDO::FETCH_ASSOC);
								
									?>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Surname</label>
                                                    <input name="surname" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['patient_last_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Given Name</label>
                                                    <input name="given_name" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['patient_first_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Middle Name (Optional)</label>
                                                    <input name="middle_name" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['patient_middle_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Suffix</label>
                                                    <input name="suffix_name" type="text" class="form-control"
                                                        autocomplete="off"
                                                        value="<?php echo $row['patient_suffix_name']; ?>">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Type of Patient</label>
                                                    <select name="patient_type" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled selected>Select Type</option>
                                                        <option value="In-patient"
                                                            <?php echo ($row['type_of_patient'] == 'In-patient') ? 'selected' : ''; ?>>
                                                            In-patient
                                                        </option>
                                                        <option value="Out-patient"
                                                            <?php echo ($row['type_of_patient'] == 'Out-patient') ? 'selected' : ''; ?>>
                                                            Out-patient
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Gender</label>
                                                    <select name="gender" class="custom-select form-control"
                                                        required="true">
                                                        <option value="" disabled selected>Select Gender</option>
                                                        <option value="Male"
                                                            <?php echo ($row['sex'] == 'Male') ? 'selected' : ''; ?>>
                                                            Male
                                                        </option>
                                                        <option value="Female"
                                                            <?php echo ($row['sex'] == 'Female') ? 'selected' : ''; ?>>
                                                            Female
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Civil Status</label>
                                                    <input name="civil_status" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['civil_status']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date Of Birth</label>
                                                    <div class="input-group date">
                                                        <input type="text" name="dob" class="form-control date-picker"
                                                            id="datepicker1" required="true" autocomplete="off"
                                                            placeholder="mm/dd/yyyy"
                                                            value="<?php echo $row['birthday']; ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Place Of Birth</label>
                                                    <input name="birth_place" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['place_of_birth']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Occupation</label>
                                                    <input name="occupation" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['occupation']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Educational Attainment</label>
                                                    <input name="educational_attainment" type="text"
                                                        class="form-control" required="true" autocomplete="off"
                                                        value="<?php echo $row['educational_attainment']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Race</label>
                                                    <input name="race" type="text" class="form-control" required="true"
                                                        autocomplete="off" value="<?php echo $row['race']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Permanent Address</label>
                                                    <input name="address" type="text" class="form-control date-picker"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['address_region']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Barangay</label>
                                                    <input name="barangay" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['address_barangay']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Province</label>
                                                    <input name="province" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['address_province']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">City/Municipality</label>
                                                    <input name="city" type="text" class="form-control" required="true"
                                                        autocomplete="off"
                                                        value="<?php echo $row['address_city_municipality']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Contact Number</label>
                                                    <input name="contact_number" type="number" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['contact_number']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Nationality</label>
                                                    <input name="nationality" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row['nationality']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Attach CSV File:</label>
                                                        <input name="csv" id="file" type="file" class="form-control"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label style="font-size:16px;"><b></b></label>
                                                    <div class="modal-footer justify-content-center">

                                                        <button type="button"
                                                            class="btn btn-primary nextButton">Next</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 222222222222222222222222222222222222222222222222222222222222222222222222-->
                    <div id="step2" class="form-step">
                        <div class="content container-fluid">

                            <!-- WELCOME MESSAGE -->
                            <div class="page-header">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="welcome d-flex justify-content-between align-items-center">
                                            <h3 class="page-title">Patient History</h3>

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
                                        <?php
								$query2 = $dbh->query("SELECT * FROM patient_history_info  WHERE patient_id = '$get_id'");
								$row2 = $query2->fetch(PDO::FETCH_ASSOC);								
									?>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Smoking</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="smoking"
                                                            id="yesOption" value="TRUE"
                                                            <?php echo ($row2['smoking'] == 'TRUE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="smoking"
                                                            id="noOption" value="FALSE"
                                                            <?php echo ($row2['smoking'] == 'FALSE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">No. of years smoking</label>
                                                    <input name="years_smoking" type="number" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row2['estimate_years_smoking']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Physical Activity</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="physical_activity" id="yesOption" value="TRUE"
                                                            <?php echo ($row2['physical_activity'] == 'TRUE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="physical_activity" id="noOption" value="FALSE"
                                                            <?php echo ($row2['physical_activity'] == 'FALSE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <?php
                                                    // Decode the JSON string into a PHP array
                                                    $dietArray = isset($row2['diet']) ? json_decode($row2['diet'], true) : [];
                                                ?>
                                                <div class="form-group">
                                                    <label class="custom-label">Diet</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option1"
                                                            name="diet[]" value="Meat"
                                                            <?php echo in_array('Meat', $dietArray) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="option1">Meat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option2"
                                                            name="diet[]" value="Fruit"
                                                            <?php echo in_array('Fruit', $dietArray) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="option2">Fruit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option3"
                                                            name="diet[]" value="Carbohydrates"
                                                            <?php echo in_array('Carbohydrates', $dietArray) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="option3">Carbohydrates</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option4"
                                                            name="diet[]" value="Other"
                                                            <?php echo in_array('Other', $dietArray) ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="option4">Other</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Drinking of Alcohol</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="drinking_alcohol" id="yesOption" value="TRUE"
                                                            <?php echo ($row2['drinking_alcohol'] == 'TRUE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="drinking_alcohol" id="noOption" value="FALSE"
                                                            <?php echo ($row2['drinking_alcohol'] == 'FALSE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">No. of years drinking</label>
                                                    <input name="years_drinking" type="number" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row2['estimate_years_alcohol']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Number of Sexual-Partners</label>
                                                    <input name="no_sexual" type="number" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row2['no_of_sexual_partners']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Use of contraceptives</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="use_contraceptives" id="yesOption" value="TRUE"
                                                            <?php echo ($row2['use_of_contraceptive'] == 'TRUE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="use_contraceptives" id="noOption" value="FALSE"
                                                            <?php echo ($row2['use_of_contraceptive'] == 'FALSE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Early Age Sexual Intercourse</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="early_age_sexual" id="yesOption" value="TRUE"
                                                            <?php echo ($row2['early_age_sexual_intercourse'] == 'TRUE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="early_age_sexual" id="noOption" value="FALSE"
                                                            <?php echo ($row2['early_age_sexual_intercourse'] == 'FALSE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Chemical Exposure</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="chemical_exposure" id="yesOption" value="TRUE"
                                                            <?php echo ($row2['chemical_exposure'] == 'TRUE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="chemical_exposure" id="noOption" value="FALSE"
                                                            <?php echo ($row2['chemical_exposure'] == 'FALSE') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Family History/Cancer</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="family_history" id="yesOption" value="true"
                                                            <?php echo ($row2['family_history_with_cancer'] === 'true') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="family_history" id="noOption" value="false"
                                                            <?php echo ($row2['family_history_with_cancer'] === 'false') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Hepatitis B Virus</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="hepatitis"
                                                            id="yesOption" value="true"
                                                            <?php echo ($row2['hepatitis_b_virus'] === 'true') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="hepatitis"
                                                            id="noOption" value="false"
                                                            <?php echo ($row2['hepatitis_b_virus'] === 'false') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Height (cm)</label>
                                                    <input name="height" type="text" class="form-control" id="height"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row2['height']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Weight (Kg)</label>
                                                    <input name="weight" type="text" class="form-control" id="weight"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row2['weight']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">BMI Classification</label>
                                                    <select name="bmi" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled>Select Type</option>
                                                        <option value="Under-weight"
                                                            <?php echo ($row2['bmi'] == 'Under-weight') ? 'selected' : ''; ?>>
                                                            Under-weight</option>
                                                        <option value="Normal"
                                                            <?php echo ($row2['bmi'] == 'Normal') ? 'selected' : ''; ?>>
                                                            Normal</option>
                                                        <option value="Over-weight"
                                                            <?php echo ($row2['bmi'] == 'Over-weight') ? 'selected' : ''; ?>>
                                                            Over-weight</option>
                                                        <option value="Obese"
                                                            <?php echo ($row2['bmi'] == 'Obese') ? 'selected' : ''; ?>>
                                                            Obese</option>
                                                    </select>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Human Papilloma Virus Infection</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="papilloma"
                                                            id="yesOption" value="true"
                                                            <?php echo ($row2['human_papillomavirus'] === 'true') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="papilloma"
                                                            id="noOption" value="false"
                                                            <?php echo ($row2['human_papillomavirus'] === 'false') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Helicobacter Pylori Virus
                                                        Infection</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="helicobacter"
                                                            id="yesOption" value="true"
                                                            <?php echo ($row2['helicobacter_pylori_virus'] === 'true') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="helicobacter"
                                                            id="noOption" value="false"
                                                            <?php echo ($row2['helicobacter_pylori_virus'] === 'false') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label style="font-size:16px;"><b></b></label>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button"
                                                            class="btn btn btn-primary prevButton">Previous</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label style="font-size:16px;"><b></b></label>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button"
                                                            class="btn btn-primary nextButton">Next</button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--3333333333333333333333333333333333333333333333333333333333333333333333333-->
                    <div id="step3" class="form-step">
                        <div class="content container-fluid">

                            <!-- WELCOME MESSAGE -->
                            <div class="page-header">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="welcome d-flex justify-content-between align-items-center">
                                            <h3 class="page-title">Cander Data</h3>

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
                                        <?php
								$query3 = $dbh->query("SELECT * FROM patient_cancer_info  WHERE patient_id = '$get_id'");
								$row3 = $query3->fetch(PDO::FETCH_ASSOC);								
									?>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date of Consultation</label>
                                                    <div class="input-group date">
                                                        <input name="doc" type="text" class="form-control date-picker"
                                                            id="datepicker2" required="true" autocomplete="off"
                                                            placeholder="mm/dd/yyyy"
                                                            value="<?php echo $row3['consultation_date']; ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date of Diagnosis</label>
                                                    <div class="input-group date">
                                                        <input name="dod" type="text" class="form-control date-picker"
                                                            id="datepicker3" required="true" autocomplete="off"
                                                            placeholder="mm/dd/yyyy"
                                                            value="<?php echo $row3['diagnosis_date']; ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="page-header">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div
                                                        class="welcome d-flex justify-content-between align-items-center">
                                                        <h3 class="page-title">Primary Site</h3>

                                                    </div>
                                                    <ul class="breadcrumb">
                                                        <li class="breadcrumb-item active"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Valid Diagnosis Non-microscopic</label>
                                                    <select name="non_microscopic" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled>Select Type</option>
                                                        <option value="N/A"
                                                            <?php echo ($row3['valid_diagnosis_non_microscopic'] == 'N/A') ? 'selected' : ''; ?>>
                                                            N/A</option>
                                                        <option value="Death Certificate"
                                                            <?php echo ($row3['valid_diagnosis_non_microscopic'] == 'Death Certificate') ? 'selected' : ''; ?>>
                                                            Death Certificate</option>
                                                        <option value="Clinical Investigation"
                                                            <?php echo ($row3['valid_diagnosis_non_microscopic'] == 'Clinical Investigation') ? 'selected' : ''; ?>>
                                                            Clinical Investigation</option>
                                                        <option value="Clinical Only"
                                                            <?php echo ($row3['valid_diagnosis_non_microscopic'] == 'Clinical Only') ? 'selected' : ''; ?>>
                                                            Clinical Only</option>
                                                        <option value="Specific Tumor Markers"
                                                            <?php echo ($row3['valid_diagnosis_non_microscopic'] == 'Specific Tumor Markers') ? 'selected' : ''; ?>>
                                                            Specific Tumor Markers</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Valid Diagnosis Microscopic</label>
                                                    <select name="microscopic" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled selected>Select Type</option>
                                                        <option value="N/A"
                                                            <?php echo ($row3['valid_diagnosis_microscopic'] == 'N/A') ? 'selected' : ''; ?>>
                                                            N/A</option>
                                                        <option value="Cytology Hematology"
                                                            <?php echo ($row3['valid_diagnosis_microscopic'] == 'Cytology Hematology') ? 'selected' : ''; ?>>
                                                            Cytology Hematology</option>
                                                        <option value="Histology of Metastatis"
                                                            <?php echo ($row3['valid_diagnosis_microscopic'] == 'Histology of Metastatis') ? 'selected' : ''; ?>>
                                                            Histology of Metastatis</option>
                                                        <option value="Histology of Primary"
                                                            <?php echo ($row3['valid_diagnosis_microscopic'] == 'Histology of Primary') ? 'selected' : ''; ?>>
                                                            Histology of Primary</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Multiple Primaries</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="multiple_primaries" id="yesOption" value="true"
                                                            <?php echo ($row3['multiple_primaries'] === 'true') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="multiple_primaries" id="noOption" value="false"
                                                            <?php echo ($row3['multiple_primaries'] === 'false') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Primary Site</label>
                                                    <select name="primary_site" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled>Select Type</option>
                                                        <option value="N/A"
                                                            <?php echo ($row3['primary_site'] == 'N/A') ? 'selected' : ''; ?>>
                                                            N/A</option>
                                                        <option value="Brain"
                                                            <?php echo ($row3['primary_site'] == 'Brain') ? 'selected' : ''; ?>>
                                                            Brain</option>
                                                        <option value="Bladder"
                                                            <?php echo ($row3['primary_site'] == 'Bladder') ? 'selected' : ''; ?>>
                                                            Bladder</option>
                                                        <option value="Breast"
                                                            <?php echo ($row3['primary_site'] == 'Breast') ? 'selected' : ''; ?>>
                                                            Breast</option>
                                                        <option value="Colon"
                                                            <?php echo ($row3['primary_site'] == 'Colon') ? 'selected' : ''; ?>>
                                                            Colon</option>
                                                        <option value="Corpus-uteri"
                                                            <?php echo ($row3['primary_site'] == 'Corpus-uteri') ? 'selected' : ''; ?>>
                                                            Corpus-uteri</option>
                                                        <option value="Esophagus"
                                                            <?php echo ($row3['primary_site'] == 'Esophagus') ? 'selected' : ''; ?>>
                                                            Esophagus</option>
                                                        <option value="Kidney"
                                                            <?php echo ($row3['primary_site'] == 'Kidney') ? 'selected' : ''; ?>>
                                                            Kidney</option>
                                                        <option value="Larynx"
                                                            <?php echo ($row3['primary_site'] == 'Larynx') ? 'selected' : ''; ?>>
                                                            Larynx</option>
                                                        <option value="Leukemia"
                                                            <?php echo ($row3['primary_site'] == 'Leukemia') ? 'selected' : ''; ?>>
                                                            Leukemia</option>
                                                        <option value="Liver"
                                                            <?php echo ($row3['primary_site'] == 'Liver') ? 'selected' : ''; ?>>
                                                            Liver</option>
                                                        <option value="Lung"
                                                            <?php echo ($row3['primary_site'] == 'Lung') ? 'selected' : ''; ?>>
                                                            Lung</option>
                                                        <option value="Skin"
                                                            <?php echo ($row3['primary_site'] == 'Skin') ? 'selected' : ''; ?>>
                                                            Skin</option>
                                                        <option value="Nasopharynx"
                                                            <?php echo ($row3['primary_site'] == 'Nasopharynx') ? 'selected' : ''; ?>>
                                                            Nasopharynx</option>
                                                        <option value="Oral"
                                                            <?php echo ($row3['primary_site'] == 'Oral') ? 'selected' : ''; ?>>
                                                            Oral</option>
                                                        <option value="Ovary"
                                                            <?php echo ($row3['primary_site'] == 'Ovary') ? 'selected' : ''; ?>>
                                                            Ovary</option>
                                                        <option value="Prostate"
                                                            <?php echo ($row3['primary_site'] == 'Prostate') ? 'selected' : ''; ?>>
                                                            Prostate</option>
                                                        <option value="Rectum"
                                                            <?php echo ($row3['primary_site'] == 'Rectum') ? 'selected' : ''; ?>>
                                                            Rectum</option>
                                                        <option value="Stomach"
                                                            <?php echo ($row3['primary_site'] == 'Stomach') ? 'selected' : ''; ?>>
                                                            Stomach</option>
                                                        <option value="Testis"
                                                            <?php echo ($row3['primary_site'] == 'Testis') ? 'selected' : ''; ?>>
                                                            Testis</option>
                                                        <option value="Thyroid"
                                                            <?php echo ($row3['primary_site'] == 'Thyroid') ? 'selected' : ''; ?>>
                                                            Thyroid</option>
                                                        <option value="Uterine"
                                                            <?php echo ($row3['primary_site'] == 'Uterine') ? 'selected' : ''; ?>>
                                                            Uterine</option>
                                                    </select>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Others Primary site</label>
                                                    <input name="other_primary" type="text"
                                                        class="form-control date-picker" required="true"
                                                        autocomplete="off"
                                                        value="<?php echo $row3['primary_site_others']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Tumor Size</label>
                                                    <input name="tumor_size" type="number" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['tumor_size']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Nodes</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="nodes"
                                                            id="positiveOption" value="Positive"
                                                            <?php echo ($row3['nodes'] == 'Positive') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="positiveOption">Positive</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="nodes"
                                                            id="negativeOption" value="Negative"
                                                            <?php echo ($row3['nodes'] == 'Negative') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="negativeOption">Negative</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Metastasis</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="metastasis"
                                                            id="metastatisOptionPresent" value="Present"
                                                            <?php echo ($row3['metastasis'] == 'Present') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="metastatisOptionPresent">Present</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="metastasis"
                                                            id="metastatisOptionAbsent" value="Absent"
                                                            <?php echo ($row3['metastasis'] == 'Absent') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="metastatisOptionAbsent">Absent</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Cancer Stage</label>
                                                    <select name="cancer_stage" class="custom-select form-control"
                                                        required="true">
                                                        <option value="">Select Type</option>
                                                        <option value="I"
                                                            <?php echo ($row3['cancer_stage'] == 'I') ? 'selected' : ''; ?>>
                                                            I</option>
                                                        <option value="II"
                                                            <?php echo ($row3['cancer_stage'] == 'II') ? 'selected' : ''; ?>>
                                                            II</option>
                                                        <option value="III"
                                                            <?php echo ($row3['cancer_stage'] == 'III') ? 'selected' : ''; ?>>
                                                            III</option>
                                                        <option value="IV"
                                                            <?php echo ($row3['cancer_stage'] == 'IV') ? 'selected' : ''; ?>>
                                                            IV</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Treatment</label>
                                                    <select name="patient_treatment" class="custom-select form-control"
                                                        required="true">
                                                        <option value="">Select Type</option>
                                                        <option value="Surgery"
                                                            <?php echo ($row3['patient_treatment'] == 'Surgery') ? 'selected' : ''; ?>>
                                                            Surgery</option>
                                                        <option value="Chemotherapy"
                                                            <?php echo ($row3['patient_treatment'] == 'Chemotherapy') ? 'selected' : ''; ?>>
                                                            Chemotherapy</option>
                                                        <option value="Immunotherapy"
                                                            <?php echo ($row3['patient_treatment'] == 'Immunotherapy') ? 'selected' : ''; ?>>
                                                            Immunotherapy</option>
                                                        <option value="Others"
                                                            <?php echo ($row3['patient_treatment'] == 'Others') ? 'selected' : ''; ?>>
                                                            Others</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Status</label>
                                                    <select name="patient_status" class="custom-select form-control"
                                                        required="true">
                                                        <option value="" disabled>Select Status</option>
                                                        <option value="Alive"
                                                            <?php echo ($row3['patient_status'] == 'Alive') ? 'selected' : ''; ?>>
                                                            Alive</option>
                                                        <option value="Disposition"
                                                            <?php echo ($row3['patient_status'] == 'Disposition') ? 'selected' : ''; ?>>
                                                            Disposition</option>
                                                        <option value="Dead"
                                                            <?php echo ($row3['patient_status'] == 'Dead') ? 'selected' : ''; ?>>
                                                            Dead</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Cause of Death</label>
                                                    <input name="cod" type="text" class="form-control" required="true"
                                                        autocomplete="off"
                                                        value="<?php echo $row3['cause_of_death']; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Place of Death</label>
                                                    <input name="pod" type="text" class="form-control" required="true"
                                                        autocomplete="off"
                                                        value="<?php echo $row3['place_of_death']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date of Death</label>
                                                    <div class="input-group date">
                                                        <input name="death_date" type="text"
                                                            class="form-control date-picker" id="datepicker4"
                                                            required="true" autocomplete="off" placeholder="mm/dd/yyyy"
                                                            value="<?php echo $row3['date_of_death']; ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i
                                                                    class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Transferred Hospital</label>
                                                    <input name="transferred_hospital" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['transferred_hospital']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Reason for Referral</label>
                                                    <input name="referral_reason" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['reason_for_referral']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Final Diagnosis :</label>
                                                    <textarea id="textarea1" name="final_diagnosis" class="form-control"
                                                        required
                                                        maxlength="150"><?php echo htmlspecialchars($row3['final_diagnosis']); ?></textarea>
                                                </div>

                                            </div>
                                        </div>
                                        <div class=" page-header">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div
                                                        class="welcome d-flex justify-content-between align-items-center">
                                                        <h3 class="page-title">Submitter Information</h3>

                                                    </div>
                                                    <ul class="breadcrumb">
                                                        <li class="breadcrumb-item active"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Last Name</label>
                                                    <input name="last_name" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['completed_by_lname']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">First Name</label>
                                                    <input name="first_name" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['completed_by_fname']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Middle Name</label>
                                                    <input name="sub_middle_name" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['completed_by_mname']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Designation</label>
                                                    <input name="designation" type="text" class="form-control"
                                                        required="true" autocomplete="off"
                                                        value="<?php echo $row3['designation']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12 ml-auto">
                                                <div class="form-group">
                                                    <label style="font-size:16px;"><b></b></label>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button"
                                                            class="btn btn btn-primary prevButton">Previous</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label style="font-size:16px;"><b></b></label>
                                                    <div class="modal-footer justify-content-center">
                                                        <button class="btn btn-primary" name="submit" id=""
                                                            data-toggle="modal">Submit</button>
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

    <script src="./assets/js/script.js"></script>
    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
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




    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/chart.js"></script>

    <!-- Select2 JS -->
    <script src="./assets/js/select2.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="./assets/js/moment.min.js"></script>
    <script src="./assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatable JS -->
    <script src="./assets/js/jquery.dataTables.min.js"></script>
    <script src="./assets/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="./assets/js/app.js"></script>
</body>

</html>