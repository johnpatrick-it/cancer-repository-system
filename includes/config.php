<?php
$dbHost = 'localhost';
$dbUsername = 'root'; 
$dbPassword = '';     
$dbName = 'pcc-cancer-repo-system';


$connection = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
