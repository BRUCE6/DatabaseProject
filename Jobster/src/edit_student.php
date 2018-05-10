<?php $ptitle = "Jobster | Edit";?>
<?php include 'server.php';
    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username']))
    {
        header('location: /Jobster/start.html');
    }
?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/head.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/menu_student.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/nav_student.php';?>
<div class = "content">
	<form method = "post" action="edit_student.php">
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<table>
    		<tr>
    			<th width = 20%>Name</th>
    			<td><input type = "text" name = "student_name"></td>
    		</tr>
    		<tr>
    			<th>University</th>
    			<td><input type = "text" name = "student_university"></td>
    		</tr>
    		<tr>
    			<th>Major</th>
    			<td><input type = "text" name = "student_major"></td>
    		</tr>
    		<tr>
    			<th>GPA</th>
    			<td><input type = "text" name = "student_gpa"></td>
    		</tr>
    		<tr>
    			<th>keywords</th>
    			<td><input type = "text" name = "student_keywords"></td>
    		</tr>
    		<tr>
    			<th><button type = "submit" name = "edit_student" class = "btn">Update</button></th>
    			<td></td>
    		</tr>
		</table>
		
	</form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>