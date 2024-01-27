<?php 
session_start();
include_once("../includes/config.php");

//This function is for saving the patient-registry-two to patient_history_info
//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY repo_user FILE)
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit; 
}

if (!$db_connection) {
    die("Error connecting to the database: " . pg_last_error());
}

echo '<pre>';
print_r($_POST);
echo '</pre>';


//Issue on getting the latest patient_id NEED FIX 
$patient_id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $smoking = $_POST['smoking'];
    $estimate_years_smoking = $_POST['estimate_years_smoking'];
    $physical_activity = $_POST['physical_activity'];
    $diet = $_POST['diet'];
    $drinking_alcohol = $_POST['drinking_alcohol'];
    $estimate_years_alcohol = $_POST['estimate_years_alcohol'];
    $no_of_sexual_partners = $_POST['no_of_sexual_partners'];
    $use_of_contraceptive = $_POST['use_of_contraceptive'];
    $early_age_sexual_intercourse = $_POST['early_age_sexual_intercourse'];
    $chemical_exposure = $_POST['chemical_exposure'];
    $family_history_with_cancer = $_POST['family_history_with_cancer'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $classification_bmi = $_POST['classification_bmi'];
    $human_papillomavirus = $_POST['human_papillomavirus'];    
    $helicobacter_pylori_virus = $_POST['helicobacter_pylori_virus'];
    $hepatitis_b_virus = $_POST['hepatitis_b_virus'];


    //parameterized SQL query
    $query = "INSERT INTO public.patient_history_info (
        smoking, estimate_years_smoking, physical_activity, diet, drinking_alcohol, 
        estimate_years_alcohol, chemical_exposure, no_of_sexual_partners, 
        early_age_sexual_intercourse, use_of_contraceptive, family_history_with_cancer, 
        height, weight, classification_bmi, human_papillomavirus, helicobacter_pylori_virus, 
        hepatitis_b_virus, patient_id
    ) 
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16, $17, $18)";

    $params = array(
        $smoking, $estimate_years_smoking, $physical_activity, $diet, $drinking_alcohol, 
        $estimate_years_alcohol, $chemical_exposure, $no_of_sexual_partners, 
        $early_age_sexual_intercourse, $use_of_contraceptive, $family_history_with_cancer, 
        $height, $weight, $classification_bmi, $human_papillomavirus, $helicobacter_pylori_virus, 
        $hepatitis_b_virus, $patient_id
    );

    $result = pg_query_params($db_connection, $query, $params);

    if ($result) {
        header("Location: patient-registry-three.php");
        exit;
    } }else {
        echo "Error inserting data: " . pg_last_error($db_connection);
    }
pg_close($db_connection);
