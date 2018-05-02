<?php include('server.php');?>
<!DOCTYPE html>
<html>
<head>
	<title>User Login</title>
	<link rel = "stylesheet" type = "text/css" href = "style.css">
</head>
<body>
	<div class = "header">
		<h2>Login</h2>
	</div>
	
	<form method = "post" action="login_company.php">
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<div class = "input-group">
			<label>Company Name</label>
			<input type = "text" name = "companyname">
		</div>
		<div class = "input-group">
			<label>Password</label>
			<input type = "password" name = "password">
		</div>
		<div class = "input-group">
			<button type = "submit" name = "login_company" class = "btn">Login</button>
		</div>
		<p>
			Don't have an account? <a href = "signup_company.php">Sign Up</a>
		</p>
	</form>
</body>
</html>