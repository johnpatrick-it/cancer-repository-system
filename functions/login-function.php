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
            // Fetch the admin row from the result
            $adminRow = pg_fetch_assoc($adminResult);
            if ($adminRow) {
             
                $hashedAdminPassword = $adminRow['password'];

              
                $adminId = $adminRow['admin_id']; 

               
                if (password_verify($password, $hashedAdminPassword)) {
                    
                    $token = md5(uniqid(rand(), true));
                    $token_password = md5($password);
                    $token_id = $token_password.$token;

                
                    $insertAuthQuery = "INSERT INTO authentication (admin_id, token) VALUES ($1, $2)";
                    $insertAuthStmt = pg_prepare($db_connection, "insert_auth_query", $insertAuthQuery);
                    if ($insertAuthStmt) {
                        $insertAuthResult = pg_execute($db_connection, "insert_auth_query", array($adminId, $token_id));
                        if (!$insertAuthResult) {
                            echo "Error inserting authentication data.";
                            exit;
                        }
                    } else {
                        echo "Authentication statement preparation failed.";
                        exit;
                    }

                    $department = $adminRow['department'];
                    $adminName = $adminRow['lastname'];

                    if ($department === 'Repository') {
                        $_SESSION['admin_id'] = $adminId;
                        $_SESSION['lastname'] = $adminName;
                        $_SESSION['token'] = $token; // Store token in session for further authentication
                        header("Location: index.php");
                        exit;
                    } else {
                        exit;
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
            exit;
        }
    } else {
        exit;
    }
}

function userLogin($email, $password) {
    global $db_connection;

    // User Login Query
    $userQuery = "SELECT repo_user_id, hospital_id, user_fname, user_mname, user_lname, email, password, salt FROM public.repo_user WHERE email = $1";
    $userStmt = pg_prepare($db_connection, "fetch_user_password_query", $userQuery);

    if ($userStmt) {
        $userResult = pg_execute($db_connection, "fetch_user_password_query", array($email));

        if ($userResult) {
            $userRow = pg_fetch_assoc($userResult);
            if ($userRow) {
                $storedPassword = $userRow['password'];
                $storedSalt = $userRow['salt'];

                if (!empty($storedSalt)) {
                    // User hashed the password
                    if (password_verify($password . $storedSalt, $storedPassword)) {
                        // Password is correct
                        $_SESSION['repo_user_id'] = $userRow['repo_user_id'];
                        $_SESSION['user_fname'] = $userRow['user_fname'];
                        $_SESSION['user_mname'] = $userRow['user_mname'];
                        $_SESSION['user_lname'] = $userRow['user_lname'];
                        $_SESSION['email'] = $userRow['email'];
                        $_SESSION['hospital_id'] = $userRow['hospital_id'];


                        header("Location: user-side/user-landing-page.php");
                        exit;
                    } else {
                        // Invalid password
                        $_SESSION['wrong-credentials'] = "Incorrect password";
                        header("location: login.php");
                        exit;
                    }
                } else {
                    // User did not hash the password, assuming it's plaintext
                    if ($password === $storedPassword) {
                        // Password is correct
                        $_SESSION['repo_user_id'] = $userRow['repo_user_id'];
                        $_SESSION['user_fname'] = $userRow['user_fname'];
                        $_SESSION['user_mname'] = $userRow['user_mname'];
                        $_SESSION['user_lname'] = $userRow['user_lname'];
                        $_SESSION['email'] = $userRow['email'];
                        $_SESSION['hospital_id'] = $userRow['hospital_id'];

                        header("Location: user-side/user-landing-page.php");
                        exit;
                    } else {
                        // Invalid password
                        $_SESSION['wrong-credentials'] = "Incorrect password";
                        header("location: login.php");
                        exit;
                    }
                }
            } else {
                // User not found
                $_SESSION['not-found'] = "User not found";
                header("location: login.php");
                exit;
            }
        } else {
            exit;
        }
    } else {
        exit;
    }
}
?>