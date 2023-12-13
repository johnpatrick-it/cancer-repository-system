<?php
  $host = "user=postgres password=[sbit4e-4thyear-capstone-2023] host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres";
  $username = "postgres";
  $password = "sbit4e-4thyear-capstone-2023";
  $database = "postgres";

  $db_connection = pg_connect("$host dbname=$database user=$username password=$password");

session_start();
$AdminID = $_SESSION['admin_id'] ?? '';
error_reporting(E_ALL);

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('.../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hospitalName = $_POST['hospital-name'] ?? '';
    $hospitalLevel = $_POST['level'] ?? '';
    $institution = $_POST['institution'] ?? '';
    $region = $_POST['region'] ?? '';
    $province = $_POST['province'] ?? '';
    $city = $_POST['city'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $street = $_POST['street'] ?? '';
    $hospitalEquipments = $_POST['hospital-equipment'] ?? '';
}

    if ($db_connection) {
        $query = "INSERT INTO hospital_general_information (admin_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, hospital_equipments) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
        
        $result = pg_prepare($db_connection, "insert_query", $query);

        if ($result) {
            $result_exec = pg_execute($db_connection, "insert_query", array($AdminID, $hospitalName, $hospitalLevel, $institution, $region, $province, $city, $barangay, $street, $hospitalEquipments));

            if ($result_exec) {
                header("Location: /hospital-information.php");
                exit();
            } else {
                echo "Error executing query: " . pg_last_error($db_connection);
            }
        } else {
            echo "Error preparing query: " . pg_last_error($db_connection);
        }

        pg_close($db_connection);
    } else {
        echo "Failed to connect to the database.";
    }



