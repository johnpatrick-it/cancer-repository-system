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

    // Retrieve form data
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

    // Prepare the SQL query
    $query = "INSERT INTO public.patient_general_info (
        type_of_patient, patient_last_name, patient_first_name, patient_middle_name,
        sex, civil_status, birthday, nationality,
        occupation, educational_attainment, race, repo_user_id, address_region, address_barangay, address_province, address_city_municipality
    ) 
    VALUES (
        $1, $2, $3, $4,
        $5, $6, $7, $8, $9,
        $10, $11, $12, $13, $14, $15, $16
    )";

    $params = array(
        $type_of_patient, $patient_last_name, $patient_first_name, $patient_middle_name,
        $sex, $civil_status, $birthday, $nationality,
        $occupation, $educational_attainment, $race, $repoUserId,
        $address_region, $address_barangay, $address_province, $address_city_municipality
    );

$result = pg_query_params($db_connection, $query, $params);

if ($result) {
    // Fetch the patient_id
    $query = "SELECT patient_id FROM public.patient_general_info WHERE repo_user_id = $1 ORDER BY patient_id DESC LIMIT 1";
    $result_patient_id = pg_query_params($db_connection, $query, array($repoUserId));

    if ($result_patient_id) {
        $row_patient_id = pg_fetch_assoc($result_patient_id);
        $patient_id = $row_patient_id['patient_id'];

        // Store patient_id in session
        $_SESSION['patient_id'] = $patient_id;

        // Redirect to the next page
        header('Location: patient-registry-two.php');
        exit;
    } else {
        echo "Error fetching patient_id: " . pg_last_error($db_connection);
    }
} }else {
    echo "Error inserting data: " . pg_last_error($db_connection);
}

   
pg_close($db_connection);


