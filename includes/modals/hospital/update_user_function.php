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
            
                // Check if the query was successful
    if ($result_exec) {
        $log_timestamp = date("Y-m-d");
        $log_action = "User info update"; // Your desired log action

        $insertLogQuery = "INSERT INTO repo_admin_logs (repo_admin_id, repo_admin_uuid, log_timestamp, log_action) VALUES ($1, $2, $3, $4)";
        $result_insert_log = pg_query_params($db_connection, $insertLogQuery, array($AdminID, $repoId, $log_timestamp, $log_action));
        
        if ($result_insert_log) {
            // Log inserted successfully
            echo "Log inserted successfully!";
        } else {
            // Error inserting log
            $error_message = pg_last_error($db_connection);
            echo "Error inserting log: " . $error_message;
        }
    } else {
        echo "error: " . pg_last_error($db_connection);
    }
           
        } 
    } 

}

?>