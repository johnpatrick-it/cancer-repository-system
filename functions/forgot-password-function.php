<?php
session_start();
include_once("send-verification-function.php");
include_once("user-send-verification.php");
include_once("../includes/config.php");

// If user login button
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Check for empty fields
    if (empty($email)) {
        $_SESSION['emptyfieldsUser'] = "Please fill out all the fields";
        header("location: ../forgot-password.php");
        exit();
    }

    // Check if the email exists in the admin_users table
    $queryAdmin = 'SELECT * FROM admin_users WHERE email = $1';
    $resultAdmin = pg_query_params($db_connection, $queryAdmin, array($email));

    if (!$resultAdmin) {
        die("Error in SQL query: " . pg_last_error());
    }

    $admin = pg_fetch_assoc($resultAdmin);

    // Check if the email exists in the repo_user table
    $queryUser = 'SELECT * FROM repo_user WHERE email = $1';
    $resultUser = pg_query_params($db_connection, $queryUser, array($email));

    if (!$resultUser) {
        die("Error in SQL query: " . pg_last_error());
    }

    $user = pg_fetch_assoc($resultUser);
    
    if ($admin) {
        // Admin found, redirect to appropriate admin page
        $_SESSION['admin_name'] = $admin['lastname'];
        $_SESSION['admin_email'] = $admin['email'];

        sendVerificationEmail($admin, $db_connection);
        // Redirect to the verification page for admin
        header('location: ../admin_verify.php');
        exit;
    } elseif ($user) {
        // Regular user found, redirect to appropriate user page
        $_SESSION['user_name'] = $user['lastname'];
        $_SESSION['user_email'] = $user['email'];

        usersendVerificationEmail($user, $db_connection);
        // Redirect to the verification page for user
        header('location: ../user_verify.php');
        exit;
    } else {
        // User not found
        $_SESSION['not-found-user'] = "Not registered email";
        header("location: ../forgot-password.php");
        exit;
    }

    // Close the connection (optional if not needed elsewhere)
    pg_close($db_connection);
}
?>
