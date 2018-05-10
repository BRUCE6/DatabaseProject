<?php $ptitle = "Jobster | Message";?>
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
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><a href = detail_student.php?detail_student=<?php echo $r['sid']?>><?php echo $r['sname'];?></a></td>
    			<td><?php echo $r['university'];?></td>
    			<td><?php echo $r['major'];?></td>
    			
				<td>
    				<form method="post" action="detail_message.php">
        				<button type = "submit" name = "message_to" value = <?php echo $r['sid'];?>>Message</button>
    				</form>
				</td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>