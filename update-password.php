<?php 
include "includes/config.php";
include "functions/login-function.php";
?>
<!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change password</title>
        <!-- Include SweetAlert library -->
        <!-- Favicon -->
	    <link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">
        <link rel="stylesheet" href="assets/css/forgotpass.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
  
      </head>

      <body>
      <div class="left-side">
      <!-- Content for the authentication side goes here -->     
      <span class="align-1">Reset Password</span>
      <div class="align-2">
      <!-- Content for the authentication side goes here -->
      <span>Enter your new password</span>
      </div>

        <div class="col-md-6 side-image factor">
        <div class="input-box">
                <form action="functions/update-password-function.php" method="post" class="factor">
                <div class="form-group" style="margin-top:10px">
					<i class="fas fa-user icon"></i>
					<input class="form-control" name="newpassword"  type="password" placeholder="New password">
		        </div>

                <div class="form-group" style="margin-top:35px">
                    <div>
                    <i class="fas fa-user icon"></i>
					<input class="form-control" name="confirmpassword"  type="password" placeholder="Confirm password">
                    </div>
		        </div>
                
        <div class="card__form">
        <button type="submit" class="reset">Reset password</button>
        </div>            
        <div class="resend-design">
            <div class="backsgnin">
            <a href="login.php" class="arrow-sign"><i class="fas fa-long-arrow-alt-left"></i>&nbsp; Back to Log in</a>
            </div>
        </div>      
        </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    </body>

 <!-- Include SweetAlert library -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
    <script>
        function displayEmptyFieldsAlert(error) {
                    Swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }

        function displayMismatchPassword(error) {
            Swal.fire({
                title: 'Error!',
                text: error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }

         function displayPassAlreadyChange(success) {
            Swal.fire({
                title: 'Success!',
                text: success,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                // Redirect to login page after clicking OK
                if (result.isConfirmed) {
                    window.location.href = '../login.php';
                }
            });
        }


        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (isset($_SESSION['emptyFields'])) {
                $error = $_SESSION['emptyFields'];
                // Clear the session error variable
                unset($_SESSION['emptyFields']);

                // Display the error for incorrect password
                echo "displayEmptyFieldsAlert('$error');";
            }
            ?>

            <?php
            if (isset($_SESSION['password_mismatch'])) {
                $error = $_SESSION['password_mismatch'];
                // Clear the session error variable
                unset($_SESSION['password_mismatch']);

                // Display the error for user not found
                echo "displayMismatchPassword('$error');";
            }
            ?>

            <?php
            if (isset($_SESSION['password_update_success'])) {
                $error = $_SESSION['password_update_success'];
                // Clear the session error variable
                unset($_SESSION['password_update_success']);

                // Display the error for empty fields
                echo "displayPassAlreadyChange('$success');";
            }
            ?>
        });
    </script>

</html>
