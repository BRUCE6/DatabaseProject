<?php $ptitle = "Jobster | Jobs";?>
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
<!-- Applied Jobs -->
	<h2>Applied Jobs</h2>
    <?php 
    $query = "SELECT C.cid, C.cname, J.title, J.location, J.jid FROM job J JOIN company C ON J.cid = C.cid ".
        "AND J.jid IN (SELECT jid FROM apply WHERE sid = ".$_SESSION['student_id'].")";
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Company</th>
    			<th>Job Title</th>
    			<th>Location</th>
    			<th>Action</th>
    			<th>More</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['cname'];?></td>
    			<td><?php echo $r['title'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<?php 
    			     $tmp_query = "SELECT * FROM apply WHERE sid = ".$_SESSION['student_id'].
    			 			" AND jid = ".$r['jid'];
    			     #echo $tmp_query;
    			     $tmp_result = mysqli_query($db, $tmp_query);
    			?>
    			<?php if (mysqli_num_rows($tmp_result) == 0): ?>
    				<td>
        				<form method="post" action="job_student.php">
        					<input type = "hidden" name = "cid" value = <?php echo $r['cid'];?>>
            				<button type = "submit" name = "apply_job" value = <?php echo $r['jid'];?>>Apply</button>
        				</form>
    				</td>
    			<?php else: ?>
    				<td>
    					<p><?php $tmp_row = $tmp_result->fetch_assoc(); echo $tmp_row['result'];?></p>
        			</td>
    			<?php endif?>
    			<td><a href = detail_job.php?detail_job=<?php echo $r['jid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!-- Other Jobs -->
	<h2>Other jobs</h2>
    <?php 
    $query = "SELECT C.cid, C.cname, J.title, J.location, J.jid FROM job J JOIN company C ON J.cid = C.cid ".
        "AND J.jid NOT IN (SELECT jid FROM apply WHERE sid = ".$_SESSION['student_id'].")";
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Company</th>
    			<th>Job Title</th>
    			<th>Location</th>
    			<th>Action</th>
    			<th>More</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['cname'];?></td>
    			<td><?php echo $r['title'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<?php 
    			     $tmp_query = "SELECT * FROM apply WHERE sid = ".$_SESSION['student_id'].
    			 			" AND jid = ".$r['jid'];
    			     #echo $tmp_query;
    			     $tmp_result = mysqli_query($db, $tmp_query);
    			?>
    			<?php if (mysqli_num_rows($tmp_result) == 0): ?>
    				<td>
        				<form method="post" action="job_student.php">
        					<input type = "hidden" name = "cid" value = <?php echo $r['cid'];?>>
            				<button type = "submit" name = "apply_job" value = <?php echo $r['jid'];?>>Apply</button>
        				</form>
    				</td>
    			<?php else: ?>
    				<td>
    					<p><?php $tmp_row = $tmp_result->fetch_assoc(); echo $tmp_row['result'];?></p>
        			</td>
    			<?php endif?>
    			<td><a href = detail_job.php?detail_job=<?php echo $r['jid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>