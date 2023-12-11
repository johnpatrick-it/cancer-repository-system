<?php
/*$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = '';     
$dbName = 'pcc-cancer-repo-system';


$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
*/

$host = "user=postgres password=[sbit4e-4thyear-capstone-2023] host=db.tcfwwoixwmnbwfnzchbn.supabase.co port=5432 dbname=postgres";
$username = "postgres";
$password = "sbit4e-4thyear-capstone-2023";
$database = "postgres";

$db_connection = pg_connect("$host dbname=$database user=$username password=$password");

if (!$db_connection) {
    die("Connection failed: " . pg_last_error());
} else {
    echo "Connected successfully";
    // You can perform database operations here for debugging purposes
}
?>
