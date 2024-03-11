<?php
session_start();
include_once("../includes/config.php");

function sanitizeString($input) {
    // Remove leading and trailing whitespace
    $input = trim($input);
    // Return sanitized string
    return $input;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize input
    $adminId = isset($_SESSION['admin_id']) ? ($_SESSION['admin_id']) : '';
    $adminId = filter_var(trim($adminId), FILTER_VALIDATE_INT);

    $newpass = isset($_POST['newpassword']) ? ($_POST['newpassword']) : '';
    $newpass = sanitizeString($newpass);

    $confirmpass = isset($_POST['confirmpassword']) ? ($_POST['confirmpassword']) : '';
    $confirmpass = sanitizeString($confirmpass);

    // Check for empty fields
    if (empty($newpass) || empty($confirmpass)) {
        $_SESSION['emptyFields'] = "Please fill out all the fields";
        header("location: ../update-password.php");
        exit;
    }

    if ($newpass !== $confirmpass) {
        $_SESSION['password_mismatch'] = "Passwords do not match";
        header("location: ../update-password.php");
        exit;
    }

    // Hash the password
    $password = password_hash($newpass, PASSWORD_DEFAULT);

    // Prepare update query
    $query = "UPDATE admin_users 
              SET 
                password = $1         
              WHERE 
                admin_id = $2";

    $result = pg_prepare($db_connection, "update_query", $query);

    if ($result) {
        // Execute update query
        $result_exec = pg_execute($db_connection, "update_query", array($password, $adminId));
        
        // Check if the query was successful
        if ($result_exec) {
            // Password updated successfully
            $_SESSION['password_update_success'] = "Password updated successfully";
            header("location: ../login.php");
            exit;
        } else {
            // Error updating password
            $_SESSION['password_update_error'] = "Error updating password";
            header("location: ../update-password.php");
            exit;
        }
    } else {
        // Error preparing query
        $_SESSION['password_update_error'] = "Error updating password";
        header("location: ../update-password.php");
        exit;
    }
}
?>
