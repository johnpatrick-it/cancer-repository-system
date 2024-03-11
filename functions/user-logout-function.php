<?php 

// Logout code
session_start();

// Clear sensitive session data
unset($_SESSION['repo_user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['password']);

// Destroy the session
session_destroy();

// Redirect to the login page or wherever you want
header("Location: ../login.php");
exit();

?>