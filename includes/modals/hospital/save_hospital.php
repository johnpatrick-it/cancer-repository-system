<?php
session_start();
include_once("../../../includes/config.php");
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the equipment_id from the form
    $equipment_id = $_POST['hospital_equipment'];

    // Store the equipment_id in a session variable
    $_SESSION['equipment_id'] = $equipment_id;
}

$AdminID = $_SESSION['admin_id'] ?? '';

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $hospitalName = $_POST['hospital_name'] ?? '';
    $hospitalLevel = $_POST['level'] ?? '';
    $institution = $_POST['institution_level3'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $street = $_POST['street'] ?? '';
    $specialty = $_POST['specialty'] ?? '';
    $hospital_equipments = $_POST['hospital_equipment'] ?? [];
    

    // Check if the connection was successful
    if ($db_connection) {
        // Prepare the INSERT query for hospital_general_information table
        $query = "INSERT INTO hospital_general_information (admin_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, specialty, hospital_equipments) 
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)";
        
        // Prepare the statement
        $result = pg_prepare($db_connection, "insert_query", $query);

        if ($result) {
            // Execute the prepared statement
            $result_exec = pg_execute($db_connection, "insert_query", array($AdminID, $hospitalName, $hospitalLevel, $institution, $region, $province, $city, $barangay, $street, $specialty, implode(', ', $equipmentIds)));

            if ($result_exec) {
                $_SESSION['add-hospital'] = "New hospital added successfully!";
                header("Location: /hospital-information.php");
                exit();
            } else {
                echo "Error executing query: " . pg_last_error($db_connection);
            }
        } else {
            echo "Error preparing query: " . pg_last_error($db_connection);
        }

        // Close the database connection
        pg_close($db_connection);
    } else {
        echo "Failed to connect to the database.";
    }
}
?>
