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
		<?php 
            $query = "SELECT * FROM student WHERE sid = ".$_SESSION['student_id'];
            #echo $query;
            $result = mysqli_query($db, $query);
            $r = $result->fetch_assoc();
        ?>
		<table>
    		<tr>
    			<th width = 20%>Name</th>
    			<td><input type = "text" name = "student_name" value = '<?php echo $r['sname']?>'></td>
    		</tr>
    		<tr>
    			<th>University</th>
    			<td><input type = "text" name = "student_university" value = '<?php echo $r['university']?>'></td>
    		</tr>
    		<tr>
    			<th>Major</th>
    			<td><input type = "text" name = "student_major" value = '<?php echo $r['major']?>'></td>
    		</tr>
    		<tr>
    			<th>GPA</th>
    			<td><input type = "text" name = "student_gpa" value = '<?php echo $r['GPA']?>'></td>
    		</tr>
    		<tr>
    			<th>keywords</th>
    			<td><input type = "text" name = "student_keywords" value = '<?php echo $r['keywords']?>'></td>
    		</tr>
    		<tr>
    			<th><button type = "submit" name = "edit_student" class = "btn">Update</button></th>
    			<td></td>
    		</tr>
		</table>
	</form>
	<h2>Resume</h2>
	<?php if (count($resume_errors) > 0): ?>
    	<div class="error">
    		<?php foreach ($resume_errors as $error):?>
    			<p><?php echo $error;?></p>
    		<?php endforeach?>
    	</div>
    <?php endif?>
	<form method = 'post' enctype = 'multipart/form-data' action = 'edit_student.php'>
    	<table>
    		<tr>
            	<th width = 32%><button type = 'submit' name = 'upload_resume'>upload</button></th>
            	<td><input type = 'file' name = 'resume'></td>
    		</tr>
    	</table>
	</form>
	<?php if (count($resume_success) > 0): ?>
	<div class="success">
		<?php foreach ($resume_success as $s):?>
			<p><?php echo $s;?></p>
		<?php endforeach?>
	</div>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>