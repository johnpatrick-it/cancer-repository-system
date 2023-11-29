<?php
$dbHost = 'localhost';
$dbUsername = 'root'; // Replace 'username' with your actual database username
$dbPassword = '';     // Replace 'password' with your actual database password
$dbName = 'pcc-cancer-repo-system';


$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
