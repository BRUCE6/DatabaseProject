<?php $ptitle = "Jobster | Job";?>
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
<?php if (isset($_SESSION["username"])):?>
	<?php 
	mysqli_query($db, "START TRANSACTION");
    $query = "SELECT J.time, J.location, J.title, J.salary, J.background, J.description, C.cname FROM job J, company C WHERE J.cid = C.cid AND jid = ".
            $_GET['detail_job']." LOCK IN SHARE MODE";
    #echo $query;
    $result = mysqli_query($db, $query);
    $r = $result->fetch_assoc();
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th width="20%">Post time</th>
    			<td><?php echo $r['time'];?></td>
    		</tr>
    		<tr>
    			<th>Company</th>
    			<td><?php echo $r['cname'];?></td>
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
    				<form method = 'post' action = 'recommend_job.php'>
    					<input type = 'hidden' name = 'job_id' value = <?php echo $_GET['detail_job']?>>
    					<button type = "submit">Recommend Job</button>
    				</form>
    			</th>
    			<td></td>
			</tr>
    	</table>
    <?php endif?>
    <?php mysqli_query($db, "COMMIT"); ?>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>