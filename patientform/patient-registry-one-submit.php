<?php 
session_start();

//This function is saving the patient-registry-one to patient_general_info using 
//postgre sql insert

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


$query_fetch_hospital_id = "SELECT hospital_id FROM public.repo_user WHERE repo_user_id = $1";
$params_fetch_hospital_id = array($_SESSION['repo_user_id']);
$result_hospital_id = pg_query_params($db_connection, $query_fetch_hospital_id, $params_fetch_hospital_id);

if ($result_hospital_id) {
    $row_hospital_id = pg_fetch_assoc($result_hospital_id);
    $hospital_id = $row_hospital_id['hospital_id'];

    // Retrieving data sa patient-registry-one.php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type_of_patient = $_POST['type_of_patient'];
        $patient_last_name = $_POST['patient_lname_initial'];
        $patient_first_name = $_POST['patient_fname_initial'];
        $patient_middle_name = $_POST['patient_mname'];
        $sex = $_POST['sex'];
        $civil_status = $_POST['civil_status'];
        $birthday = $_POST['birthday'];
        $address_region = $_POST['address_region'];
        $address_barangay = $_POST['address_barangay'];
        $address_province = $_POST['address_province'];
        $address_city_municipality = $_POST['address_city_municipality'];
        $nationality = $_POST['nationality'];
        $occupation = $_POST['occupation'];
        $educational_attainment = $_POST['educational_attainment'];
        $race = $_POST['race'];

        $repoUserId = $_SESSION['repo_user_id'];
    

    // Insert SQL query to public.patient_general_info
    $query = "INSERT INTO public.patient_general_info (
        type_of_patient, patient_last_name, patient_first_name, patient_middle_name,
        sex, civil_status, birthday, nationality, occupation, educational_attainment, 
        race, repo_user_id, hospital_id, address_region, address_barangay, address_province, address_city_municipality
    ) 
    VALUES (
        $1, $2, $3, $4,
        $5, $6, $7, $8, $9,
        $10, $11, $12, $13, 
        $14, $15, $16, $17
    ) RETURNING patient_id";

    $params = array(
        $type_of_patient, $patient_last_name, $patient_first_name, $patient_middle_name,
        $sex, $civil_status, $birthday, $nationality,
        $occupation, $educational_attainment, $race, $repoUserId, $hospital_id,
        $address_region, $address_barangay, $address_province, $address_city_municipality
    );

    $result_patient_id = pg_query_params($db_connection, $query, $params);

    if ($result_patient_id) {
        $row_patient_id = pg_fetch_assoc($result_patient_id);
        $patient_id = $row_patient_id['patient_id'];

        // Storing patient_id session (VERY IMPORTANT!)
        $_SESSION['patient_id'] = $patient_id;

        // Redirect to patient-registry-two.php
        header('Location: patient-registry-two.php');
        exit;
    } else {
        // Handle the error case for the patient insertion
        die("Error inserting patient information: " . pg_last_error());
    }
} }else {
    // Handle the error case for fetching hospital_id
    die("Error fetching hospital_id: " . pg_last_error());
}