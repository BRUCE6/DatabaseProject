<?php $ptitle = "Jobster | People";?>
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
    <?php 
    	mysqli_query($db, "START TRANSACTION");
        $query = "SELECT J.time, J.location, J.title, J.salary, J.background, J.description, C.cname FROM job J, company C WHERE J.cid = C.cid AND  jid = ".
                $_POST['job_id']." LOCK IN SHARE MODE";
        #echo $query;
        $result = mysqli_query($db, $query);
        $r = $result->fetch_assoc();
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Company</th>
    			<th>Location</th>
    			<th>Title</th>
    			<th>Salary</th>
    			
    		</tr>
    		<tr>
    			<td><?php echo $r['cname'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<td><?php echo $r['title'];?></td>
    			<td><?php echo $r['salary'];?></td>
    		</tr>
    	</table>
    <?php endif?>
    <?php mysqli_query($db, "COMMIT"); ?>
<!--     Friends -->
	<h2>Friends</h2>
    <?php 
    $query = "SELECT sid, sname, university, major FROM student WHERE sid != ".$_SESSION['student_id'].
        " AND sid IN (SELECT sid2 FROM friend WHERE sid1 = ".$_SESSION['student_id'].")";
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Name</th>
    			<th>University</th>
    			<th>Major</th>
    			<th>Action</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><a href = detail_student.php?detail_student=<?php echo $r['sid']?>><?php echo $r['sname'];?></a></td>
    			<td><?php echo $r['university'];?></td>
    			<td><?php echo $r['major'];?></td>
    			
				<td>
    				<form method="post" action="detail_job.php?detail_job=<?php echo $_POST['job_id']?>">
    					<input type = "hidden" name = "recommend_to" value = <?php echo $r['sid']?>>
        				<button type = "submit" name = "recommend_job" value = <?php echo $_POST['job_id'];?>>Recommend</button>
    				</form>
				</td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>

</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>