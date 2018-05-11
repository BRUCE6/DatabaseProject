<?php $ptitle = "Jobster | Job";?>
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
<?php if (isset($_SESSION["companyname"])):?>
	<?php 
    $query = "SELECT time, location, title, salary, background, description FROM job WHERE jid = ".$_GET['job_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
<!--     For edit job post -->
    	<table>
    		<?php foreach ($result as $r):?>
        		<tr>
        			<th width="20%">Post time</th>
        			<td><?php echo $r['time'];?></td>
        		</tr>
        		<tr>
        			<th>Location</th>
        			<td><?php echo $r['location'];?></td>
        		</tr>
        		<tr>
        			<th>Title</th>
        			<td><?php echo $r['title'];?></td>
        		</tr>
        		<tr>
        			<th>Salary</th>
        			<td><?php echo $r['salary'];?></td>
        		</tr>
        		<tr>
        			<th>Background</th>
        			<td><?php echo $r['background'];?></td>
        		</tr>
        		<tr>
        			<th height = 100>description</th>
        			<td><?php echo $r['description'];?></td>
        		</tr>
        		<tr>
        			<th>
        			<form method = "post" action = "edit_job.php">
        				<button type = "submit" name = "job_id" value = <?php echo $_GET['job_id']?>>Edit</button>
        			</form>
        			</th>
    				<td></td>
    			</tr>
    		<?php endforeach?>
    	</table>
    	
<!--     	For broadcast job -->
		<h2>Broadcast</h2>
		<?php include('errors.php'); ?>
		<form method = "post" action = "setting_job.php?job_id=<?php echo $_GET['job_id']?>">
    		<input type = "hidden" name = "job_id" value = <?php echo $_GET['job_id']?>>
    		<table>
        		<tr>
        			<th width = 40%>University</th>
        			<td><input type = "text" name = "job_university"></td>
        		</tr>
        		<tr>
        			<th>Major</th>
        			<td><input type = "text" name = "job_major" ></td>
        		</tr>
        		<tr>
        			<th>Minimum GPA</th>
        			<td><input type = "text" name = "job_gpa" ></td>
        		</tr>
        		<tr>
        			<th>Keyword 1</th>
        			<td><input type = "text" name = "job_keyword1" ></td>
        		</tr>
        		<tr>
        			<th>Keyword 2</th>
        			<td><input type = "text" name = "job_keyword2" ></td>
        		</tr>
        		<tr>
        			<th><button type = "submit" name = "job_checknumber">Check number</button></th>
        			<td></td>
        		</tr>
        		<tr>
        			<th><button type = "submit" name = "job_broadcast">Broadcast</button></th>
        			<td></td>
        		</tr>
    		</table>
		</form>
		<?php include('count_number.php'); ?>
    <?php endif?>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>