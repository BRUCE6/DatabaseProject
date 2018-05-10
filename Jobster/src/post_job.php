<?php $ptitle = "Jobster | Post";?>
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
	<form method = "post" action="post_job.php">
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<table>
			<tr>
    			<th width = 20%>location</th>
    			<td><input type = "text" name = "job_location"></td>
    		</tr>
    		<tr>
    			<th>title</th>
    			<td><input type = "text" name = "job_title"></td>
    		</tr>
    		<tr>
    			<th>salary</th>
    			<td><input type = "text" name = "job_salary"></td>
    		</tr>
    		<tr>
    			<th>background</th>
    			<td><input type = "text" name = "job_background"></td>
    		</tr>
    		<tr>
    			<th>description</th>
    			<td><input type = "text" name = "job_description"></td>
    		</tr>
    		<tr>
    			<th><button type = "submit" name = "job_post" class = "btn">Post</button></th>
    			<td></td>
    		</tr>
		</table>
		
	</form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>