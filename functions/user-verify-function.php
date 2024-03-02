<?php
session_start();
include_once("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verification_code'])) {

    // Retrieve the array of verification codes
    $enteredCodes = isset($_POST['verification_code']) ? $_POST['verification_code'] : [];
    // Concatenate the codes to form the entered verification code
    $enteredCode = implode('', $enteredCodes);

    $storedCode = isset($_SESSION['verification_code']) ? trim($_SESSION['verification_code']) : '';

    if (!empty($storedCode) && password_verify($enteredCode, $storedCode)) {
        // Verification code is correct, select the user based on code
        $email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

        $stmtSelectUser = pg_prepare($db_connection, 'select_user_query', 'SELECT * FROM repo_user WHERE email = $1 AND verification_code = $2');
        $result = pg_execute($db_connection, 'select_user_query', array($email, $enteredCode));

        $user = pg_fetch_assoc($result);

        if ($user) {
            // User found, update the status
            $status = 'Resetpassword';

            $stmtUpdateStatus = pg_prepare($db_connection, 'update_status_query', 'UPDATE repo_user SET status = $1 WHERE email = $2');
            pg_execute($db_connection, 'update_status_query', array($status, $email));

            // Assuming $_SESSION['user_id'] is set
            $_SESSION['repo_user_id'] = $user['repo_user_id'];
            $_SESSION['user_name'] = $user['lastname'];

            // Set the session variable to indicate successful verification
            $_SESSION['verification_success'] = true;

            // Redirect to verify.php to display the SweetAlert
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
