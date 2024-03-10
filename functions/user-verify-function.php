<?php
session_start();
include_once("../includes/config.php");

// Check if the request method is POST and verification code is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verification_code'])) {

    // Retrieve the entered verification code
    $enteredCodes = isset($_POST['verification_code']) ? $_POST['verification_code'] : [];
    $enteredCode = implode('', $enteredCodes);

    // Retrieve the stored verification code from session
    $storedCode = isset($_SESSION['verification_code']) ? trim($_SESSION['verification_code']) : '';

    // Check if the entered code matches the stored code
    if (!empty($storedCode) && password_verify($enteredCode, $storedCode)) {
        // Verification code is correct, select the user based on email and verification code
        $email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

        // Prepare and execute the query to select the user
        $stmtSelectUser = pg_prepare($db_connection, 'select_user_query', 'SELECT * FROM repo_user WHERE email = $1 AND verification_code = $2');
        $result = pg_execute($db_connection, 'select_user_query', array($email, $enteredCode));

        // Fetch user data from the result
        $user = pg_fetch_assoc($result);

        // Check if user is found
        if ($user) {
            // User found, update the status
            $status = 'Resetpassword';
            $stmtUpdateStatus = pg_prepare($db_connection, 'update_status_query', 'UPDATE repo_user SET status = $1 WHERE email = $2');
            pg_execute($db_connection, 'update_status_query', array($status, $email));

            // Set session variables
            $_SESSION['repo_user_id'] = $user['repo_user_id'];
            $_SESSION['user_name'] = $user['lastname'];

            // Set the session variable to indicate successful verification
            $_SESSION['verification_success'] = true;

            // Redirect to user-update-password.php to display success message
            header("location: ../user-update-password.php");
            exit();
        }
    } else {
        // Incorrect verification code
        $error = "Incorrect verification code";
        $_SESSION['error'] = $error;
        header("location: ../user_verify.php");
        exit();
    }

    // Close the connection
    pg_close($db_connection);
}
?>
