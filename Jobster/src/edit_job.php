<?php $ptitle = "Jobster | Edit";?>
<?php include 'server.php';
    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['companyname']))
    {
        header('location: /Jobster/start.html');
    }
?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/head.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/menu_company.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/nav_company.php';?>
<div class = "content">
	<form method = "post" action="edit_job.php">
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<?php 
    		$query = "SELECT location, title, salary, background, description FROM job WHERE jid = ".$_POST['job_id'];
    		#echo $query;
    		$result = mysqli_query($db, $query);
            $r = $result->fetch_assoc();
        ?>
		<table>
    		<tr>
    			<th width = 40%>Location</th>
    			<td><input type = "text" name = "job_location" value = '<?php echo $r['location']?>'></td>
    		</tr>
    		<tr>
    			<th>Title</th>
    			<td><input type = "text" name = "job_title" value = '<?php echo $r['title']?>'></td>
    		</tr>
    		<tr>
    			<th>salary</th>
    			<td><input type = "text" name = "job_salary" value = '<?php echo $r['salary']?>'></td>
    		</tr>
    		<tr>
    			<th>Background</th>
    			<td><input type = "text" name = "job_background" value = '<?php echo $r['background']?>'></td>
    		</tr>
    		<tr>
    			<th>description</th>
    			<td><textarea name = "job_description" rows = 10 cols= 50><?php echo $r['description']?></textarea></td>
    		</tr>
    		<tr>
    			<th><button type = "submit" name = "edit_job" class = "btn">Update</button></th>
    			<td></td>
    		</tr>
		</table>
		<input type = "hidden" name = "job_id" value = <?php echo $_POST['job_id']?>>
	</form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>