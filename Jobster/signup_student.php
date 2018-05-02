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
	
	<form method = "post" action="signup_student.php">
		<!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<div class = "input-group">
			<label>Username</label>
			<input type = "text" name = "username" value = <?php echo $username;?>>
		</div>
		<div class = "input-group">
			<label>Password</label>
			<input type = "password" name = "password">
		</div>
		<div class = "input-group">
			<label>Name</label>
			<input type = "text" name = "name" value = <?php echo $name;?>>
		</div>
		<div class = "input-group">
			<label>Unversity</label>
			<input type = "text" name = "university">
		</div>
		<div class = "input-group">
			<label>Major</label>
			<input type = "text" name = "major">
		</div>
		<div class = "input-group">
			<label>GPA</label>
			<input type = "text" name = "gpa">
		</div>
		<div class = "input-group">
			<button type = "submit" name = "signup_student" class = "btn">Sign Up</button>
		</div>
		<p>
			Already a member? <a href = "login_student.php">Login</a>
		</p>
	</form>
</body>
</html>