<?php include 'server.php' ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Signup</title>
	<link rel = "stylesheet" type = "text/css" href = "style.css">
</head>
<body>
	<div class = "header">
		<h2>Sign Up</h2>
	</div>
	
	<form method = "post" action="signup_company.php">
		<!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<div class = "input-group">
			<label>Company Name</label>
			<input type = "text" name = "companyname" value = <?php echo $companyname;?>>
		</div>
		<div class = "input-group">
			<label>Password</label>
			<input type = "password" name = "password">
		</div>
		<div class = "input-group">
			<label>Location</label>
			<input type = "text" name = "location">
		</div>
		<div class = "input-group">
			<label>Industry</label>
			<input type = "text" name = "industry">
		</div>
		<div class = "input-group">
			<button type = "submit" name = "signup_company" class = "btn">Sign Up</button>
		</div>
		<p>
			Already a member? <a href = "login_company.php">Login</a>
		</p>
	</form>
</body>
</html>