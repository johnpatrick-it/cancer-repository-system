<?php
session_start();
include_once("config.php");

$AdminID = $_SESSION['admin_id'] ?? '';


if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: .../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hospitalName = $_POST['hospital_name'] ?? '';
    $hospitalLevel = $_POST['level'] ?? '';
    $institution = $_POST['institution_level3'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $street = $_POST['street'] ?? '';
    $hospitalEquipments = $_POST['hospital_equipment'] ?? '';
    $specialty = $_POST['specialty'] ?? '';

    // Prepare query to insert hospital general information
    $query = "INSERT INTO hospital_general_information (admin_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, specialty) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
    $result = pg_prepare($db_connection, "insert_hospital_query", $query);

    if ($result) {
        // Execute insertion query for hospital general information
        $result_exec = pg_execute($db_connection, "insert_hospital_query", array($AdminID, $hospitalName, $hospitalLevel, $institution, $region, $province, $city, $barangay, $street, $specialty));
        
        if ($result_exec) {
            // Get the hospital_id of the newly inserted hospital
            $hospital_id_query = "SELECT hospital_id FROM hospital_general_information WHERE hospital_name = $1";
            $result_hospital_id = pg_query_params($db_connection, $hospital_id_query, array($hospitalName));
            
            if ($result_hospital_id) {
                $row = pg_fetch_assoc($result_hospital_id);
                $hospital_id = $row['hospital_id'];

                // Insert hospital equipment information
                foreach ($hospitalEquipments as $equipment) {
                    $equipmentIdQuery = "SELECT equipment_id FROM repo_equipment_category WHERE equipment_name = $1";
                    $result_equipment_id = pg_query_params($db_connection, $equipmentIdQuery, array($equipment));
                    if ($result_equipment_id) {
                        $row = pg_fetch_assoc($result_equipment_id);
                        $equipmentId = $row['equipment_id'];

                        // Insert into hospital_equipment table
                        $insertEquipmentQuery = "INSERT INTO hospital_equipment (hospital_id, equipment_id) VALUES ($1, $2)";
                        $result_insert_equipment = pg_query_params($db_connection, $insertEquipmentQuery, array($hospital_id, $equipmentId));

                        if (!$result_insert_equipment) {
                        }
                    } 
                }
             
            }
        } 
         
            $log_timestamp = date("Y-m-d");
            $log_action = "New hospital added"; // Your desired log action

            $insertLogQuery = "INSERT INTO repo_admin_logs (repo_admin_id, repo_admin_uuid, log_timestamp, log_action) VALUES ($1, $2, $3, $4)";
            $result_insert_log = pg_query_params($db_connection, $insertLogQuery, array($AdminID, $AdminID, $log_timestamp, $log_action));
            
            if ($result_insert_log) {
                // Log inserted successfully
                echo "Log inserted successfully!";
            } else {
                // Error inserting log
                $error_message = pg_last_error($db_connection);
                echo "Error inserting log: " . $error_message;
            }
            $_SESSION['add-hospital'] = "New hospital added successfully!";
            header("Location: ../../../hospital-information.php");
            exit();
    } 
    pg_close($db_connection);
}