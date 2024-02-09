<?php

session_start();

include('includes/config.php');


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
    $adminQuery = "SELECT admin_id, department, password FROM public.admin_users WHERE email = $1";
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

                    if ($department === 'Repository') {
                        $_SESSION['admin_id'] = $adminId;
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
    $userQuery = "SELECT repo_user_id, password, salt FROM public.repo_user WHERE email = $1";
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
                        $_SESSION['repo_user_id'] = $userId;
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

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head content here -->
</head>

<body class="account-page">
    <!-- HTML body content here -->
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="This is a Philippine Cancer Repository System">
    <meta name="keywords" content="PCC-CR, CR, Cancer Repository, Capstone, System, Repo">
    <meta name="author" content="Heionim">
    <meta name="robots" content="noindex, nofollow">
    <title>PCC CANCER REPOSITORY</title>


    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-..">

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


    <style>
    body {
        height: 100vh;
        margin: 0;
        padding: 0;
    }

    .main-wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        overflow: hidden;
    }

    .slanted-divider::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        right: -90%;
        width: 200%;
        transform: translateX(50%) skewX(-6deg);
        background: #fff;
        z-index: -1;
    }

    .left-side,
    .account-content {
        flex: 1;
        position: relative;
    }

    .left-side {
        background: linear-gradient(31.69deg,
                rgba(29, 53, 39, 0.54) -4.28%,
                rgba(24, 47, 33, 0.54) 46.44%,
                rgba(4, 41, 19, 0.54) 100.43%),
            url('./assets/img/Damo bg.png') center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: -2;
    }

    .account-logo img {
        max-width: 100%;
        width: 250px;
        height: auto;
    }

    .account-wrapper {
        max-width: 400px;
        width: 100%;
    }

    .account-content {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-header {
        text-align: center;
        margin-bottom: 0.6rem;
        font-size: 2.2rem;
        font-weight: 700;
    }

    .login-subheader {
        font-size: 0.8rem;
        text-align: center;
        padding-bottom: 3rem;
    }

    .form-group {
        margin-bottom: 10px;
        position: relative;
    }

    .form-control {
        width: calc(100% - 40px);
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0;
        outline: none;
        background: none;
        padding-left: 20px;
        transition: border-bottom 0.3s ease;
    }

    .form-control:focus {
        border-bottom: 2px solid #204A31;
    }

    .form-control::placeholder {
        color: #999;
    }

    .icon {
        position: absolute;
        top: 50%;
        font-size: 16px;
        transform: translateY(-50%);
        color: #999;
    }

    .forgot-password {
        font-size: 10px;
        margin: 0 0 2rem 0;
        color: #0B72BD;
        margin-left: -1rem;
    }

    .login-btn {
        width: 100%;
        border-radius: 10rem;
    }

    .help-link a span {
        position: fixed;
        bottom: 20px;
        right: 20px;
        text-align: right;
        font-size: 12px;
        color: #000;
    }
    </style>
</head>

<body class="account-page">

    <div class="main-wrapper">
        <!-- LEFT SIDE CONTAINER -->
        <div class="left-side slanted-divider">
            <div class="account-logo">
                <a href="index.php"><img src="assets/img/pcc-logo.png" alt="Company Logo"></a>
            </div>
        </div>
        
        <!-- RIGHT SIDE CONTAINER -->
        <div class="account-content">
            <div class="account-wrapper">
                <h3 class="login-header">Welcome!</h3>
                <p class="login-subheader">Please enter your details</p>

                <form method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <i class="fas fa-envelope icon"></i>
                        <input class="form-control" name="email"  placeholder="Email">
                    </div>
          
                    <div class="form-group">
                        <i class="fas fa-lock icon"></i>
                        <input class="form-control" name="password"  placeholder="Password">
                    </div>
             
                    <div class="form-group text-center">
                        <div class="col-auto pt-2">
                            <a class="float-left forgot-password" href="forgot-password.php">
                                Forgot password?
                            </a>
                        </div>
                        <button class="btn btn-primary login-btn" name="login" type="submit">Login</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="help-link">
            <a href="#"><span>Need Help?</span></a>
        </div>
    </div>

<!-- jQuery -->
<script src="assets/js/jquery-3.2.1.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Bootstrap Core JS -->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/app.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        <?php
        if (isset($_SESSION['wrong-credentials'])) {
            $error = $_SESSION['wrong-credentials'];
            // Clear the session error variable
            unset($_SESSION['wrong-credentials']);

            // Display the error for incorrect password 
            echo "Swal.fire({
                title: 'Error!',
                text: '$error',
                icon: 'error',
                confirmButtonText: 'OK'
            });";
        }
        ?>
    });
</script>

<script>
    $(document).ready(function () {
        <?php
        if (isset($_SESSION['not-found'])) {
            $error = $_SESSION['not-found'];
            // Clear the session error variable
            unset($_SESSION['not-found']);

            // Display the error for incorrect password 
            echo "Swal.fire({
                title: 'Error!',
                text: '$error',
                icon: 'error',
                confirmButtonText: 'OK'
            });";
        }
        ?>
    });
</script>

<script>
    $(document).ready(function () {
        <?php
        if (isset($_SESSION['emptyfields'])) {
            $error = $_SESSION['emptyfields'];
            // Clear the session error variable
            unset($_SESSION['emptyfields']);

            // Display the error for incorrect password 
            echo "Swal.fire({
                title: 'Error!',
                text: '$error',
                icon: 'error',
                confirmButtonText: 'OK'
            });";
        }
        ?>
    });
</script>

</body>

</html>