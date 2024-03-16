<!DOCTYPE html>
<html>

<head>
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

</body>

</html>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_SESSION['edit_id'])) {
    $edit_id = $_SESSION['edit_id'];
} else {
    echo "Session variable 'edit_id' is not set.";
}

if (isset($_POST['submit'])) {

    $surname = $_POST['surname'];
    $given_name = $_POST['given_name'];
    $middle_name = $_POST['middle_name'];
    $suffix_name = $_POST['suffix_name'];
    $patient_type = $_POST['patient_type'];
    $gender = $_POST['gender'];
    $civil_status = $_POST['civil_status'];
    $dob = $_POST['dob'];
    $birth_place = $_POST['birth_place'];
    $nationality = $_POST['nationality'];
    $occupation = $_POST['occupation'];
    $educational_attainment = $_POST['educational_attainment'];
    $race = $_POST['race'];
    $address = $_POST['address'];
    $barangay = $_POST['barangay'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $contact_number = $_POST['contact_number'];
    $dateInserted = date("Y-m-d");
   
    $patient_id = $edit_id;

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


    $host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";

    try {
        $dbh = new PDO("pgsql:$host");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start transaction
        $dbh->beginTransaction();

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

        // Assuming you have a way to get $patient_id

        // Update data in patient_general_info using prepared statement
        $sql2 = "UPDATE patient_general_info 
        SET type_of_patient = :patient_type,
            patient_last_name = :surname,
            patient_first_name = :given_name,
            patient_middle_name = :middle_name,
            sex = :gender,
            civil_status = :civil_status,
            birthday = :dob,
            nationality = :nationality,
            occupation = :occupation,
            educational_attainment = :educational_attainment,
            race = :race,
            address_region = :address,
            address_barangay = :barangay,
            address_province = :province,
            address_city_municipality = :city,
            patient_suffix_name = :suffix_name,
            place_of_birth = :birth_place,
            contact_number = :contact_number
        WHERE patient_id = :patient_id";

        $query = $dbh->prepare($sql2);
        $query->bindParam(':patient_id', $patient_id, PDO::PARAM_STR);
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
        $query->bindParam(':suffix_name', $suffix_name, PDO::PARAM_STR);
        $query->bindParam(':birth_place', $birth_place, PDO::PARAM_STR);
        $query->bindParam(':contact_number', $contact_number, PDO::PARAM_INT);

        $query->execute();

        $sql3 = "INSERT INTO repo_logs (repo_user_id, patient_id, log_timestamp, log_action) VALUES (:repo_user_id, :patient_id, :dateInserted, 'Update Patient Info')";
        $query3 = $dbh->prepare($sql3);
        
        // Bind parameters
        $query3->bindParam(':repo_user_id', $repo_user_id, PDO::PARAM_INT);
        $query3->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);
        $query3->bindParam(':dateInserted', $dateInserted, PDO::PARAM_STR);
        
        // Execute the query
        $query3->execute();



        
        $sql4 = "UPDATE patient_history_info 
        SET smoking = :smoking,
            estimate_years_smoking = :years_smoking,
            physical_activity = :physical_activity,
            diet = :diet,
            drinking_alcohol = :drinking_alcohol,
            estimate_years_alcohol = :years_drinking,
            chemical_exposure = :chemical_exposure,
            no_of_sexual_partners = :no_sexual,
            early_age_sexual_intercourse = :early_age_sexual,
            use_of_contraceptive = :use_contraceptives,
            family_history_with_cancer = :family_history,
            height = :height,
            weight = :weight,
            classification_bmi = :bmi,
            human_papillomavirus = :papilloma,
            helicobacter_pylori_virus = :helicobacter,
            hepatitis_b_virus = :hepatitis
        WHERE patient_id = :patient_id";

        $query4 = $dbh->prepare($sql4);
        $query4->bindParam(':patient_id', $patient_id, PDO::PARAM_STR);
        $query4->bindParam(':smoking', $smoking, PDO::PARAM_STR);
        $query4->bindParam(':years_smoking', $years_smoking, PDO::PARAM_STR);
        $query4->bindParam(':physical_activity', $physical_activity, PDO::PARAM_STR);
        $query4->bindParam(':diet', $dietJson, PDO::PARAM_STR);
        $query4->bindParam(':drinking_alcohol', $drinking_alcohol, PDO::PARAM_STR);
        $query4->bindParam(':years_drinking', $years_drinking, PDO::PARAM_STR);
        $query4->bindParam(':chemical_exposure', $chemical_exposure, PDO::PARAM_STR);
        $query4->bindParam(':no_sexual', $no_sexual, PDO::PARAM_STR);
        $query4->bindParam(':early_age_sexual', $early_age_sexual, PDO::PARAM_STR);
        $query4->bindParam(':use_contraceptives', $use_contraceptives, PDO::PARAM_STR);
        $query4->bindParam(':family_history', $family_history, PDO::PARAM_STR);
        $query4->bindParam(':height', $height, PDO::PARAM_STR);
        $query4->bindParam(':weight', $weight, PDO::PARAM_STR);
        $query4->bindParam(':bmi', $bmi, PDO::PARAM_STR);
        $query4->bindParam(':papilloma', $papilloma, PDO::PARAM_STR);
        $query4->bindParam(':helicobacter', $helicobacter, PDO::PARAM_STR);
        $query4->bindParam(':hepatitis', $hepatitis, PDO::PARAM_STR);

        $query4->execute();


        $sql5 = "UPDATE patient_cancer_info 
        SET consultation_date = :doc,
            diagnosis_date = :dod,
            valid_diagnosis_non_microscopic = :non_microscopic,
            valid_diagnosis_microscopic = :microscopic,
            multiple_primaries = :multiple_primaries,
            primary_site_others = :other_primary,
            tumor_size = :tumor_size,
            nodes = :nodes,
            metastasis = :metastasis,
            cancer_stage = :cancer_stage,
            final_diagnosis = :final_diagnosis,
            patient_treatment = :patient_treatment,
            patient_status = :patient_status,
            cause_of_death = :cod,
            place_of_death = :pod,
            date_of_death = :death_date,
            transferred_hospital = :transferred_hospital,
            reason_for_referral = :referral_reason,
            completed_by_lname = :last_name,
            completed_by_fname = :first_name,
            completed_by_mname = :sub_middle_name,
            designation = :designation,
            date_completed = :dateInserted,
            primary_site = :primary_site,
            time_stamp = NOW()
        WHERE patient_id = :patient_id";

        $query5 = $dbh->prepare($sql5);

        // Bind parameters for update
        $query5->bindParam(':patient_id', $patient_id, PDO::PARAM_STR);
        $query5->bindParam(':doc', $doc, PDO::PARAM_STR);
        $query5->bindParam(':dod', $dod, PDO::PARAM_STR);
        $query5->bindParam(':non_microscopic', $non_microscopic, PDO::PARAM_STR);
        $query5->bindParam(':microscopic', $microscopic, PDO::PARAM_STR);
        $query5->bindParam(':multiple_primaries', $multiple_primaries, PDO::PARAM_STR);
        $query5->bindParam(':other_primary', $other_primary, PDO::PARAM_STR);
        $query5->bindParam(':tumor_size', $tumor_size, PDO::PARAM_STR);
        $query5->bindParam(':nodes', $nodes, PDO::PARAM_STR);
        $query5->bindParam(':metastasis', $metastasis, PDO::PARAM_STR);
        $query5->bindParam(':cancer_stage', $cancer_stage, PDO::PARAM_STR);
        $query5->bindParam(':final_diagnosis', $final_diagnosis, PDO::PARAM_STR);
        $query5->bindParam(':patient_treatment', $patient_treatment, PDO::PARAM_STR);
        $query5->bindParam(':patient_status', $patient_status, PDO::PARAM_STR);
        $query5->bindParam(':cod', $cod, PDO::PARAM_STR);
        $query5->bindParam(':pod', $pod, PDO::PARAM_STR);
        $query5->bindParam(':death_date', $death_date, PDO::PARAM_STR);
        $query5->bindParam(':transferred_hospital', $transferred_hospital, PDO::PARAM_STR);
        $query5->bindParam(':referral_reason', $referral_reason, PDO::PARAM_STR);
        $query5->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $query5->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $query5->bindParam(':sub_middle_name', $sub_middle_name, PDO::PARAM_STR);
        $query5->bindParam(':designation', $designation, PDO::PARAM_STR);
        $query5->bindParam(':dateInserted', $dateInserted, PDO::PARAM_STR);
        $query5->bindParam(':primary_site', $primary_site, PDO::PARAM_STR);

        $query5->execute();


         

// -----------------------------------------------------------------------------------------------------------------------------------

        $dbh->commit();

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>';
    echo 'Swal.fire("Data Updated successfully!");';
    echo '</script>';

    echo '<script>';
    echo 'setTimeout(function() { window.location.href = "manage-patient.php"; }, 2000);'; 
    echo '</script>';


    } catch (PDOException $e) {
        // Rollback changes if an error occurred
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>