<?php 

session_start();
include_once("../../../includes/config.php");

function generateSalt($length = 16) {
    $randomBytes = random_bytes($length);
    return bin2hex($randomBytes);
}


function sanitizeString($input) {
    // Remove leading and trailing whitespace
    $input = trim($input);
    // Remove any HTML tags
    $input = strip_tags($input);
    // Return sanitized string
    return $input;
}

$salt = generateSalt();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $repoId = isset($_POST['repo_id']) ? ($_POST['repo_id']) : '';
    $repoId = sanitizeString($repoId); // No need for validation for UUIDs

    $firstName = isset($_POST['first_name']) ? ($_POST['first_name']) : '';
    $firstName = sanitizeString($firstName); 

    $middleName = isset($_POST['middle_name']) ? ($_POST['middle_name']) : '';
    $middleName = sanitizeString($middleName); 

    $lastName = isset($_POST['last_name']) ? ($_POST['last_name']) : '';
    $lastName = sanitizeString($lastName);

    $affiliated = isset($_POST['affiliated']) ? ($_POST['affiliated']) : '';
    $affiliated = sanitizeString($affiliated);

    $position = isset($_POST['position']) ? ($_POST['position']) : '';
    $position = sanitizeString($position);

    $email = isset($_POST['email']) ? ($_POST['email']) : '';
    $email = sanitizeString($email);

    $rawPassword = $_POST['password'] ?? '';
    $passwordToHash = $rawPassword . $salt;
    $password = password_hash($passwordToHash, PASSWORD_DEFAULT);

    if (!empty($repoId) && !empty($firstName) && !empty($lastName) && !empty($affiliated) && !empty($position) && !empty($email) && !empty($password)) {
        $query = "UPDATE repo_user 
        SET 
          hospital_id = $1, 
          user_fname = $2, 
          user_mname = $3, 
          user_lname = $4, 
          position = $5, 
          email = $6, 
          password = $7, 
          salt = $8 
        WHERE 
          repo_user_id = $9";


        $result = pg_prepare($db_connection, "update_query", $query);

        if ($result) {
            $result_exec = pg_execute($db_connection, "update_query", array($affiliated, $firstName, $middleName, $lastName, $position, $email, $password, $salt, $repoId));

            if ($result_exec) {
                $_SESSION['update-user'] = "User information updated successfully!";
                header("Location: /user-information.php");
                exit();
            } else {
                echo "Error executing query: " . pg_last_error($db_connection);
            }
        } else {
            echo "Error preparing query: " . pg_last_error($db_connection);
        }
    } else {
        echo "Required fields are missing.";
    }
}

?>