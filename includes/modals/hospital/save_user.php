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
    $firstName = $_POST['first-name'] ?? '';
    $middleName = $_POST['middle-name'] ?? '';
    $lastName = $_POST['last-name'] ?? '';
    $hospitalID = $_POST['user-hospital'] ?? '';
    $position = $_POST['position'] ?? '';
    $email = $_POST['email'] ?? '';
    $rawPassword = $_POST['password'] ?? '';

    // Hash the password
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);

    if (!empty($firstName) && !empty($lastName) && !empty($hospitalID) && !empty($position) && !empty($email) && !empty($password)) {
        $query = "INSERT INTO repo_user (admin_id, hospital_id, user_fname, user_mname, user_lname, position, email, password) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        
        $result = pg_prepare($db_connection, "insert_query", $query);

        if ($result) {
            $result_exec = pg_execute($db_connection, "insert_query", array($AdminID, $hospitalID, $firstName, $middleName, $lastName, $position, $email, $password));
            
            if ($result_exec) {
                header("Location: /user-information.php");
                exit();
            } else {
                echo "Error executing query: " . pg_last_error($db_connection);
            }
        } else {
            echo "Error preparing query: " . pg_last_error($db_connection);
        }
    } else {
        echo "Required fields are missing.";
    }
}
?>
