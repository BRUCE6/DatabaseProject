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
    			<th>More</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['sname'];?></td>
    			<td><?php echo $r['university'];?></td>
    			<td><?php echo $r['major'];?></td>
    			
				<td>
    				<form method="post" action="people_student.php">
        				<button type = "submit" name = "cancel_friendship_student" value = <?php echo $r['sid'];?>>Cancel friendship</button>
    				</form>
				</td>
    			<td><a href = detail_student.php?detail_student=<?php echo $r['sid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     Other people -->
	<h2>Others</h2>
    <?php 
    $query = "SELECT sid, sname, university, major FROM student WHERE sid != ".$_SESSION['student_id'].
        " AND sid NOT IN (SELECT sid2 FROM friend WHERE sid1 = ".$_SESSION['student_id'].")";
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
    			<th>More</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['sname'];?></td>
    			<td><?php echo $r['university'];?></td>
    			<td><?php echo $r['major'];?></td>
    			
    				
				<td>
					<form method="post" action="people_student.php">
        				<button type = "submit" name = "request_friendship_student" value = <?php echo $r['sid'];?>>Request friendship</button>
    				</form>
    			</td>
    			<td><a href = detail_student.php?detail_student=<?php echo $r['sid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    

</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>