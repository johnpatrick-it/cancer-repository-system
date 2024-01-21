<?php 
session_start();

//This function is saving the patient-registry-one to patient_general_info

//SESSION FOR REPO_USER_ID (NEEDED FOR EVERY FILE)
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

$patient_id = isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : null;

// Retrieve patient_id from the URL parameters
//$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : null;

//if (!$patient_id) {
    // Handle the case where patient_id is not provided
    //echo "Invalid request.";
    //exit;
//}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $smoking = isset($_POST['smoking']) ? $_POST['smoking'] : '';
    $estimate_years_smoking = $_POST['estimate_years_smoking'];
    $physical_activity = isset($_POST['physical_activity']) ? $_POST['physical_activity'] : '';
    $diet = implode(', ', isset($_POST['diet']) ? $_POST['diet'] : []);
    $drinking_alcohol = isset($_POST['drinking_alcohol']) ? $_POST['drinking_alcohol'] : '';
    $estimate_years_alcohol = $_POST['estimate_years_alcohol'];
    $chemical_exposure = isset($_POST['chemical_exposure']) ? $_POST['chemical_exposure'] : '';
    $no_of_sexual_partners = $_POST['no_of_sexual_partners'];
    $early_age_sexual_intercourse = $_POST['early_age_sexual_intercourse'];
    $use_of_contraceptive = $_POST['use_of_contraceptive'];
    $family_history_with_cancer = isset($_POST['family_history']) ? $_POST['family_history'] : '';
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $classification_bmi = $_POST['classification_bmi'];
    $human_papillomavirus = isset($_POST['human_papillomavirus']) ? $_POST['human_papillomavirus'] : '';
    $helicobacter_pylori_virus = isset($_POST['helicobacter_pylori_virus']) ? $_POST['helicobacter_pylori_virus'] : '';
    $hepatitis_b_virus = isset($_POST['hepatitis_b_virus']) ? $_POST['hepatitis_b_virus'] : '';

    // Prepare and execute the parameterized SQL query
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

    // Execute the parameterized query
    $result = pg_query_params($db_connection, $query, $params);


    if ($result) {
        echo "Data inserted successfully.";
        // Redirect or perform other actions as needed
    } else {
        echo "Error inserting data: " . pg_last_error($db_connection);
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
pg_close($db_connection);
