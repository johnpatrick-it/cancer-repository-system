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
    $userId = isset($_SESSION['repo_user_id']) ? $_SESSION['repo_user_id'] : '';
    // Check if it's a valid UUID format
    if (!preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){3}-[a-f\d]{12}$/i', $userId)) {
        // Handle invalid UUID
        $_SESSION['invalid_user_id'] = "Invalid user ID";
        header("location: ../user-update-password.php");
        exit;
    }

    $newpass = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';
    $newpass = sanitizeString($newpass);

    $confirmpass = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';
    $confirmpass = sanitizeString($confirmpass);

    // Check for empty fields
    if (empty($newpass) || empty($confirmpass)) {
        $_SESSION['emptyFields'] = "Please fill out all the fields";
        header("location: ../user-update-password.php");
        exit;
    }

    if ($newpass !== $confirmpass) {
        $_SESSION['password_mismatch'] = "Passwords do not match";
        header("location: ../user-update-password.php");
        exit;
    }

    // Hash the password
    $password = password_hash($newpass, PASSWORD_DEFAULT);

    // Prepare update query with parameterized queries
    $query = "UPDATE repo_user
              SET 
                password = $1         
              WHERE 
                repo_user_id = $2";

    $result = pg_prepare($db_connection, "update_query", $query);

    if ($result) {
        // Execute update query
        $result_exec = pg_execute($db_connection, "update_query", array($password, $userId));
        
        // Check if the query was successful
        if ($result_exec) {
            // Password updated successfully
            $_SESSION['password_update_success'] = "Password updated successfully";
            header("location: ../login.php");
            exit;
        } else {
            // Error updating password
            $_SESSION['password_update_error'] = "Error updating password";
            header("location: ../user-update-password.php");
            exit;
        }
    } else {
        // Error preparing query
        $_SESSION['password_update_error'] = "Error preparing query";
        header("location: ../user-update-password.php");
        exit;
    }
}
?>
