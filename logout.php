<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or homepage after logout
header('Location: login.php'); // Change 'login.php' to your actual login page
exit;
?>
