<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once("../../../includes/config.php");

function sanitizeString($input) {
    // Remove leading and trailing whitespace
    $input = trim($input);
    // Remove any HTML tags
    $input = strip_tags($input);
    // Return sanitized string
    return $input;
}

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit;
}

$AdminID = $_SESSION['admin_id'] ?? '';
$hospital_id = $_SESSION['hospital_id'] ?? '';

// Database connection parameters
$host = "user=postgres.tcfwwoixwmnbwfnzchbn password=sbit4e-4thyear-capstone-2023 host=aws-0-ap-southeast-1.pooler.supabase.com port=5432 dbname=postgres";

try {
    $dbh = new PDO("pgsql:" . $host);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // Terminate script execution if connection fails
}

// Retrieving default region and barangay based on hospital ID
$sql_uuid = "SELECT hospital_region, hospital_barangay,hospital_province, hospital_city,type_of_institution,hospital_level FROM hospital_general_information WHERE hospital_id = :hospitalId";
$stmt = $dbh->prepare($sql_uuid);

// Sanitize and validate hospital ID
$hospitalId = isset($_POST['hospital_id']) && !empty($_POST['hospital_id']) ? $_POST['hospital_id'] : $hospital_id;

$stmt->bindParam(':hospitalId', $hospitalId, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $defaultRegion = $result['hospital_region'];
    $defaultBarangay = $result['hospital_barangay'];
    $defaultProvince = $result['hospital_province'];
    $defaultCity = $result['hospital_city'];
    $defaultInstitution = $result['type_of_institution'];
    $defaultHospitaLevel = $result['hospital_level'];

} else {
    // Handle the case where no matching record is found
    echo "Hospital ID not found: $hospital_id";
    exit;
}

// Sanitize other input fields
$hospitalName = isset($_POST['hospital_name']) ? sanitizeString($_POST['hospital_name']) : '';


$hospitalLevel = isset($_POST['hospital_level']) && !empty($_POST['hospital_level']) ? sanitizeString($_POST['hospital_level']) : $defaultHospitaLevel;
$TypeInstitution = isset($_POST['type_institution']) && !empty($_POST['type_institution']) ? sanitizeString($_POST['type_institution']) : $defaultInstitution;



$Region = isset($_POST['region']) && !empty($_POST['region']) ? sanitizeString($_POST['region']) : $defaultRegion;
$Province = isset($_POST['province']) && !empty($_POST['province']) ? sanitizeString($_POST['province']) : $defaultProvince;
$City = isset($_POST['city']) && !empty($_POST['city']) ? sanitizeString($_POST['city']) : $defaultCity;
$Barangay = isset($_POST['barangay']) && !empty($_POST['barangay']) ? sanitizeString($_POST['barangay']) : $defaultBarangay;



$Street = isset($_POST['street']) ? sanitizeString($_POST['street']) : '';
$Equipments = isset($_POST['equipments']) ? sanitizeString($_POST['equipments']) : '';

// Prepare the update statement
$query = "UPDATE hospital_general_information SET hospital_name = :hospitalName, hospital_level = :hospitalLevel, type_of_institution = :typeInstitution, hospital_region = :region, hospital_province = :province, hospital_city = :city, hospital_barangay = :barangay, hospital_street = :street, hospital_equipments = :equipments WHERE hospital_id = :hospitalId";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':hospitalName', $hospitalName);
$stmt->bindParam(':hospitalLevel', $hospitalLevel);
$stmt->bindParam(':typeInstitution', $TypeInstitution);
$stmt->bindParam(':region', $Region);
$stmt->bindParam(':province', $Province);
$stmt->bindParam(':city', $City);
$stmt->bindParam(':barangay', $Barangay);
$stmt->bindParam(':street', $Street);
$stmt->bindParam(':equipments', $Equipments);
$stmt->bindParam(':hospitalId', $hospitalId);

// Execute the update statement
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error: " . $stmt->errorInfo()[2]; // Output detailed error message
}
?>