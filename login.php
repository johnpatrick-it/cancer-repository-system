<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("includes/config.php");

$wrongusername = ""; // Initialize $wrongusername
$wrongpassword = ""; // Initialize $wrongpassword

if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] > 0) {
    header('location:admin-index.php');
    exit;
} elseif (isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Check repo_admin table for admin account
    $sqlAdmin = "SELECT admin_username, admin_password FROM repo_admin WHERE admin_username = :username";
    $queryAdmin = $dbh->prepare($sqlAdmin);
    $queryAdmin->bindParam(':username', $username, PDO::PARAM_STR);
    $queryAdmin->execute();
    $admin = $queryAdmin->fetch(PDO::FETCH_ASSOC);

    $sqlUser = "SELECT user_name, password FROM repo_user WHERE user_name = :username";
    $queryUser = $dbh->prepare($sqlUser);
    $queryUser->bindParam(':username', $username, PDO::PARAM_STR);
    $queryUser->execute();
    $user = $queryUser->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $hashpass = $admin['admin_password'];
        if (password_verify($password, $hashpass)) {
            $_SESSION['userlogin'] = $admin['admin_username'];
            header('location:admin-index.php');
            exit;
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oh Snap!😕</strong> Alert <b class="alert-link">Password: </b>You entered the wrong password.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    } elseif ($user) {
        $hashpass = $user['password'];
        if (password_verify($password, $hashpass)) {
            $_SESSION['userlogin'] = $user['user_name'];
            header('location:user-index.php'); // Change this to user index page
            exit;
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oh Snap!😕</strong> Alert <b class="alert-link">Password: </b>You entered the wrong password.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
        }
    } else {
        echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oh Snap!🙃</strong> Alert <b class="alert-link">Username: </b>You entered the wrong username.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
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
	<meta name="description" content="This is a Philippine Cancer Center HR Management System">
	<meta name="keywords" content="PCC-HRMS, HRMS, Human Resource, Capstone, System, HR">
	<meta name="author" content="Heionim">
	<meta name="robots" content="noindex, nofollow">
	<title>PCC HRMS</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/pcc-logo.svg">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-..">

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
				<a href="admin-index.php"><img src="assets/img/pcc-logo.png" alt="Company Logo"></a>
			</div>
		</div>
		<!-- RIGHT SIDE CONTAINER -->
		<div class="account-content">
			<div class="account-wrapper">
				<h3 class="login-header">Welcome!</h3>
				<p class="login-subheader">Please enter your details</p>

				<form method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<i class="fas fa-envelope icon"></i>
						<input class="form-control" name="username" required type="text" placeholder="Email">
					</div>
					<?php if ($wrongusername) {
						echo $wrongusername;
					} ?>
					<div class="form-group">
						<i class="fas fa-lock icon"></i>
						<input class="form-control" name="password" required type="password" placeholder="Password">
					</div>
					<?php if ($wrongpassword) {
						echo $wrongpassword;
					} ?>
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

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/app.js"></script>
</body>

</html>