<?php
session_start();

// This function is saving the patient-registry-one to patient_general_info

// SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit;
}

$host = "user=postgres password=[sbit4e-4thyear-capstone-2023] host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres";
$username = "postgres";
$password = "sbit4e-4thyear-capstone-2023";
$database = "postgres";

$db_connection = pg_connect("$host dbname=$database user=$username password=$password");

if (!$db_connection) {
    die("Error connecting to the database: " . pg_last_error());
}

// Retrieve patient_id from the session
$patient_id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : null;

echo '<pre>';
print_r($_POST);
echo '</pre>';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consultation_date = $_POST['consultation_date'];
    $diagnosis_date = $_POST['diagnosis_date'];
    $valid_diagnosis_non_microscopic = $_POST['valid_diagnosis_non_microscopic'];
    $valid_diagnosis_microscopic = $_POST['valid_diagnosis_microscopic'];
    $multiple_primaries = $_POST['multiple_primaries'];
    $primary_site_brain = $_POST['primary_site_brain'];
    $primary_site_bladder = $_POST['primary_site_bladder'];
    $primary_site_breast = $_POST['primary_site_breast'];
    $primary_site_colon = $_POST['primary_site_colon'];
    $primary_site_corpus_uteri = $_POST['primary_site_corpus_uteri'];
    $primary_site_esophagus = $_POST['primary_site_esophagus'];
    $primary_site_kidney = $_POST['primary_site_kidney'];
    $primary_site_larynx = $_POST['primary_site_larynx'];
    $primary_site_leukemia = $_POST['primary_site_leukemia'];
    $primary_site_liver = $_POST['primary_site_liver'];
    $primary_site_lung = $_POST['primary_site_lung'];
    $primary_site_skin = $_POST['primary_site_skin'];
    $primary_site_nasopharynx = $_POST['primary_site_nasopharynx'];
    $primary_site_oral = $_POST['primary_site_oral'];
    $primary_site_ovary = $_POST['primary_site_ovary'];
    $primary_site_prostate = $_POST['primary_site_prostate'];
    $primary_site_rectum = $_POST['primary_site_rectum'];
    $primary_site_stomach = $_POST['primary_site_stomach'];
    $primary_site_testis = $_POST['primary_site_testis'];
    $primary_site_thyroid = $_POST['primary_site_thyroid'];
    $primary_site_uterine_cervix = $_POST['primary_site_uterine_cervix'];
    $primary_site_others = $_POST['primary_site_others'];
    $tumor_size = $_POST['tumor_size'];
    $nodes = $_POST['nodes'];
    $metastasis = $_POST['metastasis'];
    $cancer_stage = $_POST['cancer_stage'];
    $final_diagnosis = $_POST['final_diagnosis'];
    $patient_treatment = $_POST['patient_treatment'];
    $patient_status = $_POST['patient_status'];
    $cause_of_death = $_POST['cause_of_death'];
    $place_of_death = $_POST['place_of_death'];
    $date_of_death = $_POST['date_of_death'];
    $transferred_hospital = $_POST['transferred_hospital'];
    $reason_for_referral = $_POST['reason_for_referral'];
    $completed_by_lname = $_POST['completed_by_lname'];
    $completed_by_fname = $_POST['completed_by_fname'];
    $completed_by_mname = $_POST['completed_by_mname'];
    $designation = $_POST['designation'];
    $date_completed = $_POST['date_completed'];

        // Prepare and execute the parameterized SQL query
        $query = "INSERT INTO public.patient_cancer_info (
            patient_id, consultation_date, diagnosis_date, valid_diagnosis_non_microscopic,
            valid_diagnosis_microscopic, multiple_primaries, primary_site_brain,
            primary_site_bladder, primary_site_breast, primary_site_colon,
            primary_site_corpus_uteri, primary_site_esophagus, primary_site_kidney,
            primary_site_larynx, primary_site_leukemia, primary_site_liver,
            primary_site_lung, primary_site_skin, primary_site_nasopharynx,
            primary_site_oral, primary_site_ovary, primary_site_prostate,
            primary_site_rectum, primary_site_stomach, primary_site_testis,
            primary_site_thyroid, primary_site_uterine_cervix, primary_site_others,
            tumor_size, nodes, metastasis, cancer_stage, final_diagnosis,
            patient_treatment, patient_status, cause_of_death, place_of_death,
            date_of_death, transferred_hospital, reason_for_referral,
            completed_by_lname, completed_by_fname, completed_by_mname, designation,
            date_completed
        ) 
        VALUES (
            $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
            $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
            $21, $22, $23, $24, $25, $26, $27, $28, $29, $30,
            $31, $32, $33, $34, $35, $36, $37, $38, $39, $40,
            $41, $42, $43, $44, $45
        )";
        
        $params = array(
            $patient_id, $consultation_date, $diagnosis_date,
            $valid_diagnosis_non_microscopic, $valid_diagnosis_microscopic, $multiple_primaries,
            $primary_site_brain, $primary_site_bladder, $primary_site_breast, $primary_site_colon,
            $primary_site_corpus_uteri, $primary_site_esophagus, $primary_site_kidney,
            $primary_site_larynx, $primary_site_leukemia, $primary_site_liver,
            $primary_site_lung, $primary_site_skin, $primary_site_nasopharynx,
            $primary_site_oral, $primary_site_ovary, $primary_site_prostate,
            $primary_site_rectum, $primary_site_stomach, $primary_site_testis,
            $primary_site_thyroid, $primary_site_uterine_cervix, $primary_site_others,
            $tumor_size, $nodes, $metastasis, $cancer_stage, $final_diagnosis,
            $patient_treatment, $patient_status, $cause_of_death, $place_of_death,
            $date_of_death, $transferred_hospital, $reason_for_referral,
            $completed_by_lname, $completed_by_fname, $completed_by_mname, $designation,
            $date_completed
        );
        
        $result = pg_query_params($db_connection, $query, $params);

    //para sa destroy patient session
    if ($result) {

        unset($_SESSION['patient_id']);
    
        header("Location: patient-registry-one.php");
        exit;
    } }else {
        echo "Error inserting data: " . pg_last_error($db_connection);
    }
pg_close($db_connection);

