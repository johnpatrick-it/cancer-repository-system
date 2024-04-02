<?php
session_start();
error_reporting(E_ALL); // Enable error reporting to display all errors
ini_set('display_errors', 1);

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

    // Store hospital_id in session variable
    $_SESSION['hospital_id'] = $hospital_id;

    // Fetch user information from repo_user table
    $query_user_info = "SELECT user_fname, user_lname, user_mname, position FROM public.repo_user WHERE repo_user_id = $1";
    $result_user_info = pg_query_params($db_connection, $query_user_info, array($repo_user_id));
    $row_user_info = pg_fetch_assoc($result_user_info);
    
    // Check if user information is fetched successfully
    if ($row_user_info) {
        // Extract user information
        $first_name = htmlspecialchars($row_user_info['user_fname']);
        $last_name = htmlspecialchars($row_user_info['user_lname']);
        $middle_name = htmlspecialchars($row_user_info['user_mname']);  
        $designation = htmlspecialchars($row_user_info['position']);
    } else {
        // Output message if user information is not found
        echo "No user found with the specified ID.";
        exit; // Exiting the script if user information is not found
    }

    // Check if the action matches file-insertion-save.php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] === "file-insertion-save.php") {
        // Check if file was uploaded without errors
        if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
            // Upload directory
            $target_dir = "uploads/";
            // Path to uploaded file
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            // Move uploaded file to specified directory
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // Open uploaded CSV file
                $file = fopen($target_file, "r");
                if ($file) {
                    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                        // Extract data from CSV row
                        $diagnosis_date_str = $data[0];
                        
                        $diagnosis_date = DateTime::createFromFormat('d/m/Y', $diagnosis_date_str);
                        if ($diagnosis_date !== false) {
                            $diagnosis_date = $diagnosis_date->format('Y-m-d');
                        } else {
                            // Handle invalid diagnosis date format
                            continue;
                        }
                        
                        // Extract other data fields
                        $primary_site = $data[1];
                        $type_of_patient = $data[2];
                        $sex = $data[3];
                        $age = $data[4];
                        $patient_status = $data[5];
                        $cancer_stage = $data[6];
                        $patient_case_number = $data[7];
                        $address_city_municipality = $data[8];

                        // Prepare SQL statement with placeholders for all columns
                        $query = "INSERT INTO public.cancer_cases_general_info 
                                (diagnosis_date, primary_site, type_of_patient, sex, age, patient_status, cancer_stage, patient_case_number, address_city_municipality, repo_user_id, hospital_id, completed_by_fname, completed_by_lname, completed_by_mname, designation) 
                                VALUES 
                                ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15)";

                        // Prepare the statement
                        $stmt = pg_prepare($db_connection, "", $query);
                        if (!$stmt) {
                            echo "Error preparing SQL statement: " . pg_last_error($db_connection) . "<br>";
                            continue;
                        }

                        // Bind parameters and execute the statement
                        $result = pg_execute($db_connection, "", array(
                            $diagnosis_date,
                            $primary_site,
                            $type_of_patient,
                            $sex,
                            $age,
                            $patient_status,
                            $cancer_stage,
                            $patient_case_number,
                            $address_city_municipality,
                            $_SESSION['repo_user_id'], // Assuming you have a session variable for repo_user_id
                            $_SESSION['hospital_id'], // Assuming you have a session variable for hospital_id
                            $first_name,
                            $last_name,
                            $middle_name,
                            $designation
                        ));

                        // Check if query executed successfully
                        if ($result) {
                            $_SESSION['insertion_success'] = true;
                            // Delete the file after successful insertion
                            unlink($target_file);
                        } else {
                            echo "Error executing SQL statement: " . pg_last_error($db_connection) . "<br>";
                        }
                    }

                    // Close the CSV file
                    fclose($file);
                } else {
                    $_SESSION['insertion_success'] = false;
                }
            } else {
                $_SESSION['insertion_success'] = false;
            }
        } else {
            $_SESSION['insertion_success'] = false;
        }

        // Redirect back to file-insertion.php after processing the form submission
        header("Location: file-insertion.php");
    }
}

