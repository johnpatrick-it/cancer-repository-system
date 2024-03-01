<?php
session_start();
include_once("send-verification-function.php");
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

    $query = 'SELECT * FROM admin_users WHERE email = $1';
    $result = pg_query_params($db_connection, $query, array($email));

    if (!$result) {
        die("Error in SQL query: " . pg_last_error());
    }

    $user = pg_fetch_assoc($result);
    
    if ($user) {
        // User found, redirect to appropriate page
        $_SESSION['admin_name'] = $user['lastname'];
        $_SESSION['admin_email'] = $user['email'];

        sendVerificationEmail($user, $db_connection);
        // Redirect to the verification page
        header('location: ../verify.php');
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
