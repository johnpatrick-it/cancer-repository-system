<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
    header('Location: ../login.php');
    exit;
}
$adminID = $_SESSION['admin_id'];
$token = $_SESSION['token'] ?? '';

if(isset($_POST['password'])) {

    $password = md5($_POST['password']);
    $token_password = $password . $token;


    $query = "SELECT * FROM authentication WHERE admin_id = $1 AND token = $2";
    $params = array($adminID, $token_password);

    $result = pg_query_params($db_connection, $query, $params);

    if (!$result) {
    
        die("Query failed: " . pg_last_error($db_connection));
    }
    if (pg_num_rows($result) > 0) {

        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "password_missing";
}
?>