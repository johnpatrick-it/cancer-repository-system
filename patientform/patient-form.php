z<?php

include('../includes/config.php');

session_start();

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}

?>

<?php


if (isset($_POST['submit'])) {
    // Retrieve form data
    $surname = $_POST['surname'];
    $given_name = $_POST['given_name'];
    $middle_name = $_POST['middle_name'];
    $patient_type = $_POST['patient_type'];
    $gender = $_POST['gender'];
    $civil_status = $_POST['civil_status'];
    $dob = $_POST['dob'];
    $nationality = $_POST['nationality'];
    $birth_place = $_POST['birth_place'];
    $occupation = $_POST['occupation'];
    $educational_attainment = $_POST['educational_attainment'];
    $race = $_POST['race'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $province = $_POST['province'];
    $city = $_POST['city'];

    // Get hospital_id based on repo_user_id
    $repo_user_id = $_SESSION['repo_user_id'];
 

     // Second form 2222222222222222222222222222222222222222222222222222222222222

     $smoking = isset($_POST['smoking']) ? $_POST['smoking'] : '';
     $years_smoking = $_POST['years_smoking'];
     $physical_activity = isset($_POST['physical_activity']) ? $_POST['physical_activity'] : '';
     $diet = isset($_POST['diet']) ? $_POST['diet'] : [];
     $dietJson = json_encode($diet);
     $drinking_alcohol = isset($_POST['drinking_alcohol']) ? $_POST['drinking_alcohol'] : '';
     $years_drinking = $_POST['years_drinking'];
     $no_sexual = $_POST['no_sexual'];
     $use_contraceptives = isset($_POST['use_contraceptives']) ? $_POST['use_contraceptives'] : '';
     $early_age_sexual = isset($_POST['early_age_sexual']) ? $_POST['early_age_sexual'] : '';
     $chemical_exposure = isset($_POST['chemical_exposure']) ? $_POST['chemical_exposure'] : '';
     $family_history = isset($_POST['family_history']) ? $_POST['family_history'] : '';
     $hepatitis = isset($_POST['hepatitis']) ? $_POST['hepatitis'] : '';
     $height = $_POST['height'];
     $weight = $_POST['weight'];
     $bmi  = $_POST['bmi'];
     $papilloma = isset($_POST['papilloma']) ? $_POST['papilloma'] : '';
     $helicobacter = isset($_POST['helicobacter']) ? $_POST['helicobacter'] : '';

    // third form 333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333

    $doc = $_POST['doc'];
    $dod = $_POST['dod'];
    $non_microscopic = $_POST['non_microscopic'];
    $microscopic = $_POST['microscopic'];
    $multiple_primaries = isset($_POST['multiple_primaries']) ? $_POST['multiple_primaries'] : '';
    $primary_site = $_POST['primary_site'];
    $other_primary = $_POST['other_primary'];
    $tumor_size = $_POST['tumor_size'];
    $nodes = isset($_POST['nodes']) ? $_POST['nodes'] : '';
    $metastatis = isset($_POST['metastatis']) ? $_POST['metastatis'] : '';
    $cancer_stage = $_POST['cancer_stage'];
    $patient_treatment = $_POST['patient_treatment'];
    $patient_status = $_POST['patient_status'];
    $cod = $_POST['cod'];
    $pod = $_POST['pod'];
    $death_date = $_POST['death_date'];
    $transferred_hospital = $_POST['transferred_hospital'];
    $referral_reason = $_POST['referral_reason'];
    $final_diagnosis = $_POST['final_diagnosis'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $sub_middle_name = $_POST['sub_middle_name'];
    $designation = $_POST['designation'];
    $dateInserted = date("Y-m-d");


    $host = "host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres user=postgres password=sbit4e-4thyear-capstone-2023";

    try {
        $dbh = new PDO("pgsql:$host");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve hospital_id using prepared statement
        $sql1 = "SELECT hospital_id FROM public.repo_user WHERE repo_user_id = :repo_user_id";
        $stmt = $dbh->prepare($sql1);
        $stmt->bindParam(':repo_user_id', $repo_user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hospital_id = $result['hospital_id'];
        } else {
            // Handle the case where no matching record is found
            echo "Hospital ID not found for repo_user_id: $repo_user_id";
            exit;
        }

        if (isset($_FILES['csv']) && $_FILES['csv']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['csv']['name'];
            $file_tmp = $_FILES['csv']['tmp_name'];
        
            // Move the uploaded file to Supabase Storage
            $supabaseUrl = 'https://tcfwwoixwmnbwfnzchbn.supabase.co';
            $storagePath = __DIR__ . '/../assets/csv/'. $file_name;;

            // Upload file to Supabase Storage
            $uploadUrl = $file_name;
            file_put_contents($uploadUrl, file_get_contents($file_tmp));
            move_uploaded_file($_FILES['csv']['tmp_name'], $storagePath);

        
        
        }
        // Insert data into patient_general_info using prepared statement
        $sql2 = "INSERT INTO patient_general_info (
            patient_id,
            type_of_patient,
            patient_last_name,
            patient_first_name,
            patient_middle_name,
            sex,
            civil_status,
            birthday,
            nationality,
            occupation,
            educational_attainment,
            race,
            address_region,
            address_barangay,
            address_province,
            address_city_municipality,
            hospital_id,
            repo_user_id,
            file
        ) VALUES (
            uuid_generate_v4(), -- Generate a new UUID
            :patient_type,
            :surname,
            :given_name,
            :middle_name,
            :gender,
            :civil_status,
            :dob,
            :nationality,
            :occupation,
            :educational_attainment,
            :race,
            :address,
            :barangay,
            :province,
            :city,
            :hospital_id,
            :repo_user_id,
            :file
        ) RETURNING patient_id;
        ";
        
        $query = $dbh->prepare($sql2);
        $query->bindParam(':patient_type', $patient_type, PDO::PARAM_STR);
        $query->bindParam(':surname', $surname, PDO::PARAM_STR);
        $query->bindParam(':given_name', $given_name, PDO::PARAM_STR);
        $query->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':civil_status', $civil_status, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':nationality', $nationality, PDO::PARAM_STR);
        $query->bindParam(':occupation', $occupation, PDO::PARAM_STR);
        $query->bindParam(':educational_attainment', $educational_attainment, PDO::PARAM_STR);
        $query->bindParam(':race', $race, PDO::PARAM_STR);
        $query->bindParam(':address', $address, PDO::PARAM_STR);
        $query->bindParam(':barangay', $barangay, PDO::PARAM_STR);
        $query->bindParam(':province', $province, PDO::PARAM_STR); 
        $query->bindParam(':city', $city, PDO::PARAM_STR);
        $query->bindParam(':hospital_id', $hospital_id, PDO::PARAM_INT);
        $query->bindParam(':repo_user_id', $repo_user_id, PDO::PARAM_INT);
        $query->bindParam(':file', $uploadUrl, PDO::PARAM_STR); // Use $uploadUrl for the 'file' column


        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        $generatedPatientID = $result['patient_id'];

        // Add another insert statement
        $sql3 = "INSERT INTO patient_history_info (patient_id, smoking, estimate_years_smoking, physical_activity, diet, drinking_alcohol, estimate_years_alcohol, chemical_exposure, no_of_sexual_partners, early_age_sexual_intercourse, use_of_contraceptive, family_history_with_cancer, height, weight, classification_bmi, human_papillomavirus, helicobacter_pylori_virus, hepatitis_b_virus) 
                VALUES (:patient_id, :smoking, :years_smoking, :physical_activity, :diet, :drinking_alcohol, :years_drinking, :chemical_exposure, :no_sexual, :early_age_sexual, :use_contraceptives, :family_history, :height, :weight, :bmi, :papilloma, :helicobacter, :hepatitis)";
        $query2 = $dbh->prepare($sql3);
        
        // Bind parameters for the second insert
        $query2->bindParam(':patient_id', $generatedPatientID, PDO::PARAM_INT);
        $query2->bindParam(':smoking', $smoking, PDO::PARAM_STR);
        $query2->bindParam(':years_smoking', $years_smoking, PDO::PARAM_STR);
        $query2->bindParam(':physical_activity', $physical_activity, PDO::PARAM_STR);
        $query2->bindParam(':diet', $dietJson, PDO::PARAM_STR);
        $query2->bindParam(':drinking_alcohol', $drinking_alcohol, PDO::PARAM_STR);
        $query2->bindParam(':years_drinking', $years_drinking, PDO::PARAM_STR);
        $query2->bindParam(':chemical_exposure', $chemical_exposure, PDO::PARAM_STR);
        $query2->bindParam(':no_sexual', $no_sexual, PDO::PARAM_STR);
        $query2->bindParam(':early_age_sexual', $early_age_sexual, PDO::PARAM_STR);
        $query2->bindParam(':use_contraceptives', $use_contraceptives, PDO::PARAM_STR);
        $query2->bindParam(':family_history', $family_history, PDO::PARAM_STR);
        $query2->bindParam(':height', $height, PDO::PARAM_STR);
        $query2->bindParam(':weight', $weight, PDO::PARAM_STR);
        $query2->bindParam(':bmi', $bmi, PDO::PARAM_STR);
        $query2->bindParam(':papilloma', $papilloma, PDO::PARAM_STR);
        $query2->bindParam(':helicobacter', $helicobacter, PDO::PARAM_STR);
        $query2->bindParam(':hepatitis', $hepatitis, PDO::PARAM_STR);
        // ... (similar bindings for other parameters)
        
        // Execute the second insert
        $query2->execute();

        $sql4 = "INSERT INTO patient_cancer_info (patient_id, consultation_date, diagnosis_date, valid_diagnosis_non_microscopic,valid_diagnosis_microscopic,multiple_primaries,primary_site_others,tumor_size,nodes,metastasis,cancer_stage,final_diagnosis,patient_treatment,patient_status,cause_of_death,place_of_death,date_of_death,transferred_hospital,reason_for_referral,completed_by_lname,completed_by_fname,completed_by_mname,designation,date_completed,primary_site,time_stamp) 
                VALUES (:patient_id,:doc, :dod, :non_microscopic, :microscopic, :multiple_primaries, :other_primary, :tumor_size,:nodes, :metastasis, :cancer_stage, :final_diagnosis,:patient_treatment, :patient_status, :cod, :pod, :death_date, :transferred_hospital, :referral_reason, :last_name,:first_name, :sub_middle_name, :designation, :dateInserted,:primary_site, NOW())";

        $query3 = $dbh->prepare($sql4);
        // Bind parameters for third insert
        $query3->bindParam(':patient_id', $generatedPatientID, PDO::PARAM_INT);
        $query3->bindParam(':doc', $doc, PDO::PARAM_STR);
        $query3->bindParam(':dod', $dod, PDO::PARAM_STR);
        $query3->bindParam(':non_microscopic', $non_microscopic, PDO::PARAM_STR);
        $query3->bindParam(':microscopic', $microscopic, PDO::PARAM_STR);
        $query3->bindParam(':multiple_primaries', $multiple_primaries, PDO::PARAM_STR);
        $query3->bindParam(':other_primary', $other_primary, PDO::PARAM_STR);
        $query3->bindParam(':tumor_size', $tumor_size, PDO::PARAM_STR);
        $query3->bindParam(':nodes', $nodes, PDO::PARAM_STR);
        $query3->bindParam(':metastasis', $metastasis, PDO::PARAM_STR);
        $query3->bindParam(':cancer_stage', $cancer_stage, PDO::PARAM_STR);
        $query3->bindParam(':final_diagnosis', $final_diagnosis, PDO::PARAM_STR);
        $query3->bindParam(':patient_treatment', $patient_treatment, PDO::PARAM_STR);
        $query3->bindParam(':patient_status', $patient_status, PDO::PARAM_STR);
        $query3->bindParam(':cod', $cod, PDO::PARAM_STR);
        $query3->bindParam(':pod', $pod, PDO::PARAM_STR);
        $query3->bindParam(':death_date', $death_date, PDO::PARAM_STR);
        $query3->bindParam(':transferred_hospital', $transferred_hospital, PDO::PARAM_STR);
        $query3->bindParam(':referral_reason', $referral_reason, PDO::PARAM_STR);
        $query3->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $query3->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $query3->bindParam(':sub_middle_name', $sub_middle_name, PDO::PARAM_STR);
        $query3->bindParam(':designation', $designation, PDO::PARAM_STR);
        $query3->bindParam(':dateInserted', $dateInserted, PDO::PARAM_STR);
        $query3->bindParam(':primary_site', $primary_site, PDO::PARAM_STR);
        

        $query3->execute();

        echo "Data inserted successfully";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/pcc-logo.svg">

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
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <?php include_once("../includes/user-header.php"); ?>
        <?php include_once("../includes/user-sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="containers">
                <form method="post" action="" id="registrationForm" enctype="multipart/form-data">
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
                                                    <label class="custom-label">Surname</label>
                                                    <input name="surname" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Given Name</label>
                                                    <input name="given_name" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Middle Name (Optional)</label>
                                                    <input name="middle_name" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Suffix</label>
                                                    <input name="suffix" type="text" class="form-control"
                                                        autocomplete="off">
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
                                                        <option value="In-patient">In-patient</option>
                                                        <option value="Out-patient">Out-patient</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Gender</label>
                                                    <select name="gender" class="custom-select form-control"
                                                        required="true">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Civil Status</label>
                                                    <input name="civil_status" type="text" class="form-control"
                                                        id="password" required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date Of Birth</label>
                                                    <div class="input-group date">
                                                        <input type="text" name="dob" class="form-control date-picker"
                                                            id="datepicker1" required="true" autocomplete="off"
                                                            placeholder="mm/dd/yyyy">
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
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Occupation</label>
                                                    <input name="occupation" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Educational Attainment</label>
                                                    <input name="educational_attainment" type="text"
                                                        class="form-control" required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Race</label>
                                                    <input name="race" type="text" class="form-control" required="true"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Permanent Address</label>
                                                    <input name="address" type="text" class="form-control date-picker"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Barangay</label>
                                                    <input name="barangay" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Province</label>
                                                    <input name="province" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">City/Municipality</label>
                                                    <input name="city" type="text" class="form-control" required="true"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Contact Number</label>
                                                    <input name="contact_number" type="number" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Nationality</label>
                                                    <input name="nationality" type="text" class="form-control"
                                                        required="true" autocomplete="off">
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
                                                        <button class="btn btn btn-primary nextButton">Next</button>
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
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Smoking</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="smoking"
                                                            id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="smoking"
                                                            id="noOption" value="FALSE">
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">No. of years smoking</label>
                                                    <input name="years_smoking" type="number" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Physical Activity</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="physical_activity" id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="physical_activity" id="noOption" value="FALSE">
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Diet</label>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option1"
                                                            name="diet[]" value="Meat">
                                                        <label class="form-check-label" for="option1">Meat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option2"
                                                            name="diet[]" value="Fruit">
                                                        <label class="form-check-label" for="option2">Fruit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option3"
                                                            name="diet[]" value="Carbohydrates">
                                                        <label class="form-check-label"
                                                            for="option3">Carbohydrates</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="option4"
                                                            name="diet[]" value="Other">
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
                                                            name="drinking_alcohol" id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="drinking_alcohol" id="noOption" value="FALSE">
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">No. of years drinking</label>
                                                    <input name="years_drinking" type="number" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Number of Sexual-Partners</label>
                                                    <input name="no_sexual" type="number" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Use of contraceptives</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="use_contraceptives" id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="use_contraceptives" id="noOption" value="FALSE">
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
                                                            name="early_age_sexual" id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="early_age_sexual" id="noOption" value="FALSE">
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
                                                            name="chemical_exposure" id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="chemical_exposure" id="noOption" value="FALSE">
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
                                                            name="family_history" id="yesOption" value="true">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="family_history" id="noOption" value="false">
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
                                                            id="yesOption" value="true">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="hepatitis"
                                                            id="noOption" value="false">
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Height</label>
                                                    <input name="height" type="text" class="form-control" id="height"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Weight </label>
                                                    <input name="weight" type="text" class="form-control" id="weight"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">BMI Classification</label>
                                                    <select name="bmi" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled selected>Select Type</option>
                                                        <option value="Under-weight">Under-weight</option>
                                                        <option value="Normal">Normal</option>
                                                        <option value="Over-weight">Over-weight</option>
                                                        <option value="Obese">Obese</option>
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
                                                            id="yesOption" value="true">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="papilloma"
                                                            id="noOption" value="false">
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
                                                            id="yesOption" value="true">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="helicobacter"
                                                            id="noOption" value="false">
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
                                                        <button class="btn btn btn-primary nextButton">Next</button>
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
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date of Consultation</label>
                                                    <div class="input-group date">
                                                        <input name="doc" type="text" class="form-control date-picker"
                                                            id="datepicker2" required="true" autocomplete="off"
                                                            placeholder="mm/dd/yyyy">
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
                                                            placeholder="mm/dd/yyyy">
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
                                                        <option value="" disabled selected>Select Type</option>
                                                        <option value="N/A">N/A</option>
                                                        <option value="Death Certificate">Death Certificate</option>
                                                        <option value="Clinical Investigation">Clinical Investigation
                                                        </option>
                                                        <option value="Clinical Only">Clinical Only</option>
                                                        <option value="Specific Tumor Markers">Specific Tumor Markers
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Valid Diagnosis Microscopic</label>
                                                    <select name="microscopic" class="custom-select form-control"
                                                        required="true" autocomplete="off">
                                                        <option value="" disabled selected>Select Type</option>
                                                        <option value="N/A">N/A</option>
                                                        <option value="Cytology Hematology">Cytology Hematology</option>
                                                        <option value="Histology of Metastatis">Histology of Metastatis
                                                        </option>
                                                        <option value="Histology of Primary">Histology of Primary
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Multiple Primaries</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="multiple_primaries" id="yesOption" value="TRUE">
                                                        <label class="form-check-label" for="yesOption">Yes</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input"
                                                            name="multiple_primaries" id="noOption" value="FALSE">
                                                        <label class="form-check-label" for="noOption">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Primary Site</label>
                                                    <select name="primary_site" class="custom-select form-control"
                                                        required="true" autocomplete="off">
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
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Others Primary site</label>
                                                    <input name="other_primary" type="text"
                                                        class="form-control date-picker" required="true"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Tumor Size</label>
                                                    <input name="tumor_size" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Nodes</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="nodes"
                                                            id="positiveOption" value="Positive">
                                                        <label class="form-check-label" for="yesOption">Positive</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="nodes"
                                                            id="negativeOption" value="Negative">
                                                        <label class="form-check-label" for="noOption">Negative</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Metastasis</label>
                                                    <br>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="metastasis"
                                                            id="metastatisOption" value="Present">
                                                        <label class="form-check-label" for="noOption">Present</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" name="metastasis"
                                                            id="metastatisOption" value="Absent">
                                                        <label class="form-check-label"
                                                            for="absentOption">Absent</label>
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
                                                        <option value="I">I</option>
                                                        <option value="II">II</option>
                                                        <option value="III">III</option>
                                                        <option value="IV">IV</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Treatment</label>
                                                    <select name="patient_treatment" class="custom-select form-control"
                                                        required="true">
                                                        <option value="">Select Type</option>
                                                        <option value="Surgery">Surgery</option>
                                                        <option value="Chemotherapy">Chemotherapy</option>
                                                        <option value="Immunotherapy">Immunotherapy</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Patient Status</label>
                                                    <select name="patient_status" class="custom-select form-control"
                                                        required="true">
                                                        <option value="" disabled selected>Select Status</option>
                                                        <option value="Alive">Alive</option>
                                                        <option value="Disposition">Disposition</option>
                                                        <option value="Dead">Dead</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Cause of Death</label>
                                                    <input name="cod" type="text" class="form-control" required="true"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Place of Death</label>
                                                    <input name="pod" type="text" class="form-control" required="true"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Date of Death</label>
                                                    <div class="input-group date">
                                                        <input name="death_date" type="text"
                                                            class="form-control date-picker" id="datepicker4"
                                                            required="true" autocomplete="off" placeholder="mm/dd/yyyy">
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
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Reason for Referral</label>
                                                    <input name="referral_reason" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Final Diagnosis :</label>
                                                    <textarea id="textarea1" name="final_diagnosis" class="form-control"
                                                        required maxlength="150"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page-header">
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
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">First Name</label>
                                                    <input name="first_name" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Middle Name</label>
                                                    <input name="sub_middle_name" type="text" class="form-control"
                                                        required="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-label">Designation</label>
                                                    <input name="designation" type="text" class="form-control"
                                                        required="true" autocomplete="off">
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

    <script src="../assets/js/script.js"></script>
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