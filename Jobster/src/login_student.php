<?php include('server.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>User Login</title>
	<link rel = "stylesheet" type = "text/css" href = "../css/style_log.css">
</head>
<body>
	<div class = "header">
		<h2>Login</h2>
	</div>
	
	<form method = "post" action="login_student.php">
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<div class = "input-group">
			<label>Username</label>
			<input type = "text" name = "username">
		</div>
		<div class = "input-group">
			<label>Password</label>
			<input type = "password" name = "password">
		</div>
		<div class = "input-group">
			<button type = "submit" name = "login_student" class = "btn">Login</button>
		</div>
		<p>
			Don't have an account? <a href = "signup_student.php">Sign Up</a>
		</p>
	</form>
</body>
</html>