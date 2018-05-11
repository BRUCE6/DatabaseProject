<?php $ptitle = "Jobster | Notifications";?>
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
<!--     Apply Notify -->
	<h2>Applying Notifications</h2>
    <?php 
    $query = "SELECT J.jid, S.sid, S.sname, S.university, S.major, J.location, J.title, N.time from student S, notify_apply N, job J WHERE N.status = 'unview' AND ".
        "N.jid = J.jid AND S.sid = N.sid AND N.cid = ".$_SESSION['company_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Name</th>
    			<th>University</th>
    			<th>Major</th>
    			<th>Title</th>
    			<th>Location</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><a href = 'info_student.php?info_student=<?php $r['sid']?>'><?php echo $r['sname'];?></a></td>
    			<td><?php echo $r['university'];?></td>
    			<td><?php echo $r['major'];?></td>
    			<td><?php echo $r['title'];?></td>
    			<td><?php echo $r['location'];?></td>
    		</tr>
    		<?php 
        		$tmp_query = "UPDATE notify_apply SET status = 'view' WHERE ".
        		      "jid = ".$r['jid']." AND time = '". $r['time']."' AND sid = ".$r['sid'];
        		#echo $tmp_query;
        		$tmp_result = mysqli_query($db, $tmp_query);
    		?>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     All Apply Notify -->
	<h2>Applying Notifications History</h2>
    <?php 
    $query = "SELECT J.jid, S.sid, S.sname, S.university, S.major, J.location, J.title, N.time from student S, notify_apply N, job J WHERE N.status = 'view' AND ".
        "N.jid = J.jid AND S.sid = N.sid AND N.cid = ".$_SESSION['company_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Name</th>
    			<th>University</th>
    			<th>Major</th>
    			<th>Title</th>
    			<th>Location</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><a href = 'info_student.php?info_student=<?php echo $r['sid']?>'><?php echo $r['sname'];?></a></td>
    			<td><?php echo $r['university'];?></td>
    			<td><?php echo $r['major'];?></td>
    			<td><?php echo $r['title'];?></td>
    			<td><?php echo $r['location'];?></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>