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
        $email = isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : '';

        $stmtSelectUser = pg_prepare($db_connection, 'select_user_query', 'SELECT * FROM admin_users WHERE email = $1 AND verification_code = $2');
        $result = pg_execute($db_connection, 'select_user_query', array($email, $enteredCode));

        $user = pg_fetch_assoc($result);

        if ($user) {
            // User found, update the status
            $status = 'Resetpassword';

            $stmtUpdateStatus = pg_prepare($db_connection, 'update_status_query', 'UPDATE admin_users SET status = $1 WHERE email = $2');
            pg_execute($db_connection, 'update_status_query', array($status, $email));

            // Assuming $_SESSION['user_id'] is set
            $_SESSION['admin_id'] = $user['admin_id'];
            $_SESSION['admin_name'] = $user['lastname'];

            // Set the session variable to indicate successful verification
            $_SESSION['verification_success'] = true;

            // Redirect to verify.php to display the SweetAlert
            header("location: ../update-password.php");
            exit();
        }
    } else {
        // Incorrect verification code
        $error = "Incorrect verification code";
        $_SESSION['error'] = $error;
        header("location: ../verify.php");
        exit();
    }

    // Close the connection
    pg_close($db_connection);
}
?>
