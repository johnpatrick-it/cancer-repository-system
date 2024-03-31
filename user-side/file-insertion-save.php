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
                // Process each row of the CSV file
                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                // Extract data from CSV row
                $diagnosis_date = $data[0];
                $primary_site = $data[1];
                $type_of_patient = $data[2];
                $sex = $data[3];
                $age = $data[4];
                $patient_status = $data[5];
                $date_of_death = isset($data[6]) ? $data[6] : null; // Check if date of death is provided
                $cancer_stage = $data[7];
                $patient_case_number = $data[8];
                $address_city_municipality = $data[9];
                
                // Prepare SQL statement with placeholders
                $query = "INSERT INTO public.cancer_cases_general_info 
                          (diagnosis_date, primary_site, type_of_patient, sex, age, patient_status, date_of_death, cancer_stage, patient_case_number, address_city_municipality) 
                          VALUES 
                          (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    
                    // Prepare the statement
                    $stmt = pg_prepare($db_connection, "", $query);
                    if (!$stmt) {
                        echo "Error preparing SQL statement: " . pg_last_error($db_connection) . "<br>"; // Debugging message
                        continue; // Skip to the next iteration of the loop
                    }
                    
          	          // Bind parameters and execute the statement
                    $result = pg_execute($db_connection, "", array(
                        $diagnosis_date,
                        $primary_site,
                        $type_of_patient
                    ));
                    
                    // Check if query executed successfully
                    if (!$result) {
                        echo "Error executing SQL statement: " . pg_last_error($db_connection) . "<br>"; // Debugging message
                        continue; // Skip to the next iteration of the loop
                    }
                    
                    // Output debugging message for successful insertion
                    echo "Data inserted successfully<br>";
                }
                
                // Close the CSV file
                fclose($file);
            } else {
                echo "Error opening CSV file<br>"; // Debugging message
            }
        } else {
            echo "Error uploading file<br>"; // Debugging message
        }
    } else {
        echo "No file uploaded or error occurred<br>"; // Debugging message
    }
    
    // Redirect back to file-insertion.php after processing the form submission
    header("Location: file-insertion.php");
    exit; // Exiting the script to prevent further execution
}
?>
