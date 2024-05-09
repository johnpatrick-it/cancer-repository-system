<?php   
include "includes/config.php";
include "functions/login-function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,   initial-scale=1.0, user-scalable=0">
    <title>PCC CANCER REPOSITORY</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="./profiles/pcc-logo1.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

</head>

<body class="account-page">
    <div class="main-wrapper">
        <!-- LEFT SIDE CONTAINER -->
        <div class="left-side slanted-divider">
            <div class="account-logo">
                <a href="index.php"><img src="./profiles/pcc-logo.png" alt="Company Logo"></a>
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
                        <input class="form-control" name="email" type="email" placeholder="Email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock icon"></i>
                        <input class="form-control" name="password" type="password" placeholder="Password" autocomplete="off">
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

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
    <script>
        function displayWrongCredentialsAlert(error) {
            Swal.fire({
                title: 'Error!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

        function displayNotFoundAlert(error) {
            Swal.fire({
                title: 'Error!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

        function displayEmptyFieldsAlert(error) {
            Swal.fire({
                title: 'Error!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (isset($_SESSION['wrong-credentials'])) {
                $error = $_SESSION['wrong-credentials'];
                // Clear the session error variable
                unset($_SESSION['wrong-credentials']);

                // Display the error for incorrect password
                echo "displayWrongCredentialsAlert('$error');";
            }
            ?>

            <?php
            if (isset($_SESSION['not-found'])) {
                $error = $_SESSION['not-found'];
                // Clear the session error variable
                unset($_SESSION['not-found']);

                // Display the error for user not found
                          echo "displayNotFoundAlert('$error');";
            }
            ?>

            <?php
            if (isset($_SESSION['emptyfields'])) {
                $error = $_SESSION['emptyfields'];
                // Clear the session error variable
                unset($_SESSION['emptyfields']);

                // Display the error for empty fields
                echo "displayEmptyFieldsAlert('$error');";
            }
            ?>
        });
    </script>
</body>

</html>