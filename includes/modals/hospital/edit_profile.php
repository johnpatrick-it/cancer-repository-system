<?php 
session_start();
include_once("../../../includes/config.php");

function generateSalt($length = 16) {
    $randomBytes = random_bytes($length);
    return bin2hex($randomBytes);
}

function sanitizeString($input) {
    $input = trim(strip_tags($input));
    return $input;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $repoId = isset($_POST['repo_user_id']) ? sanitizeString($_POST['repo_user_id']) : '';
    $firstName = isset($_POST['fname']) ? sanitizeString($_POST['fname']) : '';
    $middleName = isset($_POST['mname']) ? sanitizeString($_POST['mname']) : '';
    $lastName = isset($_POST['lname']) ? sanitizeString($_POST['lname']) : '';
    $email = isset($_POST['email']) ? sanitizeString($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : ''; 

    // Generate salt and hash the password
    $salt = generateSalt();
    $passwordToHash = $password . $salt;
    $hashedPassword = password_hash($passwordToHash, PASSWORD_DEFAULT);

    if (!empty($repoId) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)) {
        $query = "UPDATE repo_user 
            SET 
              user_fname = $1, 
              user_mname = $2, 
              user_lname = $3, 
              email = $4, 
              password = $5, 
              salt = $6 
            WHERE 
              repo_user_id = $7";

        $result = pg_prepare($db_connection, "update_query", $query);
        if ($result) {
            $result_exec = pg_execute($db_connection, "update_query", array($firstName, $middleName, $lastName, $email, $hashedPassword, $salt, $repoId));
            if ($result_exec) {
                // User not found
            $_SESSION['profile-change'] = "Successfully change";
            header("location: ../../../user-profile.php");
            exit;
            } else {
                echo "error: " . pg_last_error($db_connection);
            }
        } else {
            echo "error: " . pg_last_error($db_connection);
        }
    } 
}

