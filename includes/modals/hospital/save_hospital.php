<?php
session_start();
include_once("../../../includes/config.php");

$AdminID = $_SESSION['admin_id'] ?? '';
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    $equipmentIdStmt = pg_prepare($db_connection, "equipment_query", "SELECT equipment_id FROM repo_equipment_category WHERE equipment_name = $1");

    if (!is_array($hospitalEquipments)) {
        $hospitalEquipments = [$hospitalEquipments];
    }
    
    $equipmentIds = [];
    foreach ($hospitalEquipments as $equipment) {
        $result = pg_execute($db_connection, "equipment_query", array($equipment));
        if ($result) {
            $equipmentId = pg_fetch_result($result, 0, 0);
            if ($equipmentId !== false) {
                $equipmentIds[] = $equipmentId;
            } else {
            }
        } else {
        }
    }
    var_dump($equipmentIds);
    // Convert equipment IDs array to a string
    $hospitalEquipmentsString = '{' . implode(',', $equipmentIds) . '}';

    // Construct insertion query
    $query = "INSERT INTO hospital_general_information (admin_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, hospital_equipments, specialty, equipment_id) 
    VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)";

    $result = pg_prepare($db_connection, "insert_query", $query);

    if ($result) {
        // Convert hospitalEquipments array to a comma-separated string
        $equipmentString = implode(',', $hospitalEquipments);
    
        // Execute the insertion query with the retrieved equipment_ids
    $result_exec = pg_execute($db_connection, "insert_query", array($AdminID, $hospitalName, $hospitalLevel, $institution, $region, $province, $city, $barangay, $street, NULL, $specialty, $equipmentIds[0]));
    
        if ($result_exec) {
            $_SESSION['add-hospital'] = "New hospital added successfully!";
            header("Location: ");
            exit();
        } else {
            echo "Error executing query: " . pg_last_error($db_connection);
        }
    } else {
        echo "Error preparing query: " . pg_last_error($db_connection);
    }

    pg_close($db_connection);
} else {
}

