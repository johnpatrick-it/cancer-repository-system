<?php
session_start();
error_reporting(0);

// Check if the user is logged in
if (!isset($_SESSION['repo_user_id']) || empty($_SESSION['repo_user_id'])) {
    header("Location: login.php");
    exit;
}

include('../includes/config.php');

// Retrieve repo_user_id from session
$repo_user_id = $_SESSION['repo_user_id'];

// Retrieve hospital_id for the current user
$query_hospital_id = "SELECT hospital_id FROM public.repo_user WHERE repo_user_id = $1";
$result_hospital_id = pg_query_params($db_connection, $query_hospital_id, array($repo_user_id));

if ($result_hospital_id) {
    $row_hospital_id = pg_fetch_assoc($result_hospital_id);
    $hospital_id = $row_hospital_id['hospital_id'];

    // Proceed with data insertion
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data   
        $diagnosis_date = $_POST["diagnosis_date"];
        $primary_site = $_POST["primary_site"];
        $cancer_stage = $_POST["cancer_stage"];
        $patient_type = $_POST["patient_type"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $patient_status = $_POST["patient_status"];
        // Check if patient status is "Dead" and set date_of_death accordingly
        if ($patient_status === "Dead") {
            $date_of_death = isset($_POST["date_of_death"]) ? $_POST["date_of_death"] : null;
        } else {
            $date_of_death = null;
        }
        $patient_case_number = $_POST["patient_case_number"];
        $address_city_municipality = $_POST["city"];
        $last_name = $_POST["last_name"];
        $first_name = $_POST["first_name"];
        $middle_name = $_POST["sub_middle_name"];
        $designation = $_POST["designation"];

        // Check if hospital_id is null
        if ($hospital_id === null) {
            echo "Error: Hospital ID not found for current user.";
            exit; // Stop execution
        }

        // Prepare SQL statement for patient insertion
        $query_insert = "INSERT INTO public.cancer_cases_general_info (hospital_id, diagnosis_date, primary_site, cancer_stage, type_of_patient, age, sex, patient_status, date_of_death, patient_case_number, address_city_municipality, completed_by_lname, completed_by_fname, completed_by_mname, designation, repo_user_id) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16) RETURNING patient_id";

        // Execute the query for patient insertion and return the patient_id
        $result_insert = pg_query_params($db_connection, $query_insert, array(
            $hospital_id,
            $diagnosis_date,
            $primary_site,
            $cancer_stage,
            $patient_type,
            $age,
            $gender,
            $patient_status,
            $date_of_death,
            $patient_case_number,
            $address_city_municipality,
            $last_name,
            $first_name,
            $middle_name,
            $designation,
            $repo_user_id
        ));

        // Check if the patient insertion query was successful and patient_id is returned
        if ($result_insert && pg_num_rows($result_insert) > 0) {
            $patient_id_row = pg_fetch_assoc($result_insert);
            $patient_id = $patient_id_row['patient_id'];
            // Log successful patient registration
            $log_action = "Patient Registered";
        } else {
            // Log patient registration error
            $log_action = "Patient Registration Error";
        }

        // Prepare and execute the log query for success
        $query_log_success = "INSERT INTO public.repository_logs (log_timestamp, repo_user_id, patient_id, hospital_id, completed_by_lname, completed_by_fname, completed_by_mname, designation, patient_case_number, log_action) VALUES (timezone('Asia/Manila', current_timestamp), $1, $2, $3, $4, $5, $6, $7, $8, $9)";
        $result_log_success = pg_query_params($db_connection, $query_log_success, array($repo_user_id, $patient_id, $hospital_id, $last_name, $first_name, $middle_name, $designation, $patient_case_number, $log_action));

        if (!$result_log_success) {
            echo "Error logging action: " . pg_last_error($db_connection);
            exit;
        }


        // Redirect back to patient-form-v2.php regardless of registration success
        header("Location: patient-form-v2.php");
        exit();
    }
} else {
    echo "Error retrieving hospital ID for repo_user_id: $repo_user_id";
    exit;
}