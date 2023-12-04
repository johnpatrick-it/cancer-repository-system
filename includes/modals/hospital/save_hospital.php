<?php


session_start();
$repoAdminID = $_SESSION['repo_admin_id'] ?? '';
echo "Repo Admin ID: " . $repoAdminID;
error_reporting(E_ALL);

if (!isset($_SESSION['userlogin']) || empty($_SESSION['userlogin'])) {
    header('Location: login.php');
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

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'pcc-cancer-repo-system');

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    
    $repoAdminID = $_SESSION['repo_admin_id'] ?? '';

    $stmt = $connection->prepare("INSERT INTO hospital_general_information (repo_admin_id, hospital_name, hospital_level, type_of_institution, hospital_region, hospital_province, hospital_city, hospital_barangay, hospital_street, hospital_equipments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssss",$repoAdminID, $hospitalName, $hospitalLevel, $institution, $region, $province, $city, $barangay, $street, $hospitalEquipments);

    if ($stmt->execute()) {
        header("Location: /hospital-information.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>
