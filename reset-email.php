<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<style>
  html,body { height: 100%; }

body{
	display: -ms-flexbox;
	display: -webkit-box;
	display: flex;
	-ms-flex-align: center;
	-ms-flex-pack: center;
	-webkit-box-align: center;
	align-items: center;
	-webkit-box-pack: center;
	justify-content: center;
	background-color: #f5f5f5;
}

form{
	padding-top: 10px;
	font-size: 14px;
	margin-top: 30px;
}

.card-title{ font-weight:300; }

.btn{
	font-size: 14px;
	margin-top:20px;
}

.login-form{ 
	width:320px;
	margin:20px;
}

.sign-up{
	text-align:center;
	padding:20px 0 0;
}

span{
	font-size:14px;
}
</style>
</head>
<body>

<div class="card login-form">
  <div class="card-body">
    <h3 class="card-title text-center">Reset password</h3>

    <div class="card-text">
      <form action="reset-password.php" method="POST" autocomplete="off">
        <fieldset aria-label="Password Reset Form">
          <legend class="visually-hidden">Reset Password</legend>
          <div class="form-group">
            <label for="email" aria-describedby="email-description">Enter your email address and we will send you a link to reset your password.</label>
            <input type="email" id="email" class="form-control form-control-sm" placeholder="Enter your email address" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Send password reset email</button>
          <a class="float-left sign-in" href="login.php">Already have account</a>
        </fieldset>
      </form>
    </div>
  </div>
</div>

</body>
</html>
