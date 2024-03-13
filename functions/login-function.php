<?php

session_start();

include('./includes/config.php');


function sanitizeInput($input) {
    // Use htmlspecialchars to prevent XSS attacks
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
       // Sanitize user input
       $email = sanitizeInput($_POST['email']);
       $password = sanitizeInput($_POST['password']);

    
      // Check for empty fields
      if (empty($email) || empty($password)) {
        $_SESSION['emptyfields'] = "Please fill out all the fields";
        header("location: login.php");
        exit;
    }

    // Admin Login Query
    $adminQuery = "SELECT admin_id, lastname, department, password FROM public.admin_users WHERE email = $1";
    $adminStmt = pg_prepare($db_connection, "fetch_admin_password_query", $adminQuery);

    if ($adminStmt) {
        $adminResult = pg_execute($db_connection, "fetch_admin_password_query", array($email));

        if ($adminResult) {
            $adminRow = pg_fetch_assoc($adminResult);
            if ($adminRow) {
                $hashedAdminPassword = $adminRow['password'];

                if (password_verify($password, $hashedAdminPassword)) {

                    $department = $adminRow['department'];
                    $adminId = $adminRow['admin_id'];
                    $adminName = $adminRow['lastname'];

                    if ($department === 'Repository') {
                        $_SESSION['admin_id'] = $adminId;
                        $_SESSION['lastname'] = $adminName;
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "You are not authorized to access this page.";
                    }
                } else {
                    // Proceed to user login if not admin
                    userLogin($email, $password);
                }
            } else {
                // Proceed to user login if not admin
                userLogin($email, $password);
            }
        } else {
            echo "Admin login query execution failed.";
        }
    } else {
        echo "Admin statement preparation failed.";
    }
}

function userLogin($email, $password) {
    global $db_connection;



    // User Login Query
    $userQuery = "SELECT repo_user_id, user_fname, user_mname, user_lname, email, password, salt FROM public.repo_user WHERE email = $1";
    $userStmt = pg_prepare($db_connection, "fetch_user_password_query", $userQuery);

    if ($userStmt) {
        $userResult = pg_execute($db_connection, "fetch_user_password_query", array($email));

        if ($userResult) {
            $userRow = pg_fetch_assoc($userResult);
            if ($userRow) {
                $hashedUserPassword = $userRow['password'];
                $salt = $userRow['salt'];

                if (isset($salt)) {
                    if (password_verify($password . $salt, $hashedUserPassword)) {
                        $userId = $userRow['repo_user_id'];
                        $userfname = $userRow['user_fname'];
                        $usermname = $userRow['user_mname'];
                        $userlname = $userRow['user_lname'];
                        $useremail = $userRow['email'];

                       
                        $_SESSION['repo_user_id'] = $userId;
                        $_SESSION['user_fname'] = $userfname;
                        $_SESSION['user_mname'] = $usermname;
                        $_SESSION['user_lname'] = $userlname;
                        $_SESSION['email'] = $useremail;
                 
                        header("Location: user-landing-page.php");
                        exit();
                    } else {
                           // Invalid email or password
                $_SESSION['not-found'] = "User not found";
                header("location: login.php");
                exit;
                    }
                } else {
                   // Invalid email or password
                $_SESSION['not-found'] = "User not found";
                header("location: login.php");
                exit;
                }
            } else {
                // Invalid email or password
                $_SESSION['wrong-credentials'] = "Incorrect password";
                header("location: login.php");
                exit;
            }
        } else {
            echo "User login query execution failed.";
        }
    } else {
        echo "User statement preparation failed.";
    }
}
?>
