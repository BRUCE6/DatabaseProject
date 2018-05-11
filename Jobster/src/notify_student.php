<?php $ptitle = "Jobster | Notifications";?>
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
    <h2>Friend Request</h2>
    <?php 
    $query = "SELECT S.sname, S.sid, N.answer, N.time FROM notify_friend_request N JOIN student S WHERE N.receive_status = 'unview' AND N.from_sid = S.sid AND N.to_sid = ".$_SESSION['student_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Time</th>
    			<th>Name</th>
    			<th>Action</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time'];?></td>
    			<td><?php echo $r['sname'];?></td>
    			<td>
    				<form method="post" action="notify_student.php">
    					<input type="hidden"  name="request_time" value='<?php echo $r['time'];?>'>
        				<button type = "submit" name = "accept_friendship_student" value = <?php echo $r['sid'];?>>Accept</button>
        				<button type = "submit" name = "decline_friendship_student" value = <?php echo $r['sid'];?>>Decline</button>
    				</form>
    			</td>
    		</tr>
    		<?php 
        		$tmp_query = "UPDATE notify_friend_request SET receive_status = 'view' WHERE ".
        		      "from_sid = ".$r['sid']." AND time = '". $r['time']."' AND to_sid = ".$_SESSION['student_id'];
        		#echo $tmp_query;
        		$tmp_result = mysqli_query($db, $tmp_query);
    		?>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     All Friend request -->
	<h2>Friend Request History</h2>
	<?php 
    $query = "SELECT S.sname, S.sid, N.answer, N.time FROM notify_friend_request N JOIN student S WHERE N.receive_status = 'view' AND N.from_sid = S.sid AND N.to_sid = ".$_SESSION['student_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Time</th>
    			<th>Name</th>
    			<th>Action</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time'];?></td>
    			<td><?php echo $r['sname'];?></td>
    			<?php if ($r['answer'] == null): ?>
    				<td>
        				<form method="post" action="notify_student.php">
        					<input type="hidden"  name="request_time" value='<?php echo $r['time'];?>'>
            				<button type = "submit" name = "accept_friendship_student" value = <?php echo $r['sid'];?>>Accept</button>
            				<button type = "submit" name = "decline_friendship_student" value = <?php echo $r['sid'];?>>Decline</button>
        				</form>
    				</td>
    			<?php elseif ($r['answer'] == 'yes'): ?>
    				<td><p>Accepted</p></td>
    			<?php else:?>
    				<td><p>Declined</p></td>
    			<?php endif?>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
	
<!--     Friend request outcome -->
    <h2>Request Outcome</h2>
    <?php 
    $query = "SELECT S.sname, S.sid, N.answer, N.time FROM notify_friend_request N JOIN student S WHERE N.answer_status = 'unview' AND N.to_sid = S.sid AND N.from_sid = ".$_SESSION['student_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Time</th>
    			<th>Name</th>
    			<th>Outcome</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time'];?></td>
    			<td><?php echo $r['sname'];?></td>
    			<td>
    				<?php if ($r['answer'] == 'yes'): ?>
    				<p>Agreed</p>
    				<?php else:?>
    				<p>Rejected</p>
    				<?php endif?>
    			</td>
    		</tr>
    		<?php 
        		$tmp_query = "UPDATE notify_friend_request SET answer_status = 'view' WHERE ".
        		      "to_sid = ".$r['sid']." AND time = '". $r['time']."' AND from_sid = ".$_SESSION['student_id'];
        		#echo $tmp_query;
        		$tmp_result = mysqli_query($db, $tmp_query);
    		?>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!-- Request History -->
	<h2>Request Outcome History</h2>
    <?php 
    $query = "SELECT S.sname, S.sid, N.answer, N.time FROM notify_friend_request N JOIN student S WHERE N.answer_status = 'view' AND N.to_sid = S.sid AND N.from_sid = ".$_SESSION['student_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Time</th>
    			<th>Name</th>
    			<th>Outcome</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time'];?></td>
    			<td><?php echo $r['sname'];?></td>
    			<td>
    				<?php if ($r['answer'] == 'yes'): ?>
    				<p>Agreed</p>
    				<?php elseif ($r['answer'] == 'no'):?>
    				<p>Rejected</p>
    				<?php else:?>
    				<p>Waiting for Response</p>
    				<?php endif?>
    			</td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     Job Notify -->
	<h2>Job Notifications</h2>
    <?php 
    $query = "SELECT C.cid, C.cname, J.jid, J.location, J.title, N.time from notify_job N, job J, company C WHERE N.status = 'unview' AND ".
        "N.jid = J.jid AND J.cid = C.cid AND N.sid = ".$_SESSION['student_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th width = 30%>Time</th>
    			<th>Company</th>
    			<th>Title</th>
    			<th>Location</th>
    			<th>Action</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time'];?></td>
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
        				<form method="post" action="notify_student.php">
        					<input type = "hidden" name = "cid" value = <?php echo $r['cid'];?>>
            				<button type = "submit" name = "apply_job" value = <?php echo $r['jid'];?>>Apply</button>
        				</form>
    				</td>
    			<?php else: ?>
    				<td>
    					<p><?php $tmp_row = $tmp_result->fetch_assoc(); echo $tmp_row['result'];?></p>
        			</td>
    			<?php endif?>
    		</tr>
    		<?php 
        		$tmp_query = "UPDATE notify_job SET status = 'view' WHERE ".
        		      "jid = ".$r['jid']." AND time = '". $r['time']."' AND sid = ".$_SESSION['student_id'];
        		#echo $tmp_query;
        		$tmp_result = mysqli_query($db, $tmp_query);
    		?>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     All Job Notify -->
	<h2>Job Notifications History</h2>
    <?php 
    $query = "SELECT C.cid, C.cname, J.jid, J.location, J.title, N.time from notify_job N, job J, company C WHERE N.status = 'view' AND ".
        "N.jid = J.jid AND J.cid = C.cid AND N.sid = ".$_SESSION['student_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th width = 30%>Time</th>
    			<th>Company</th>
    			<th>Title</th>
    			<th>Location</th>
    			<th>Action</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time']?></td>
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
        				<form method="post" action="notify_student.php">
        					<input type = "hidden" name = "cid" value = <?php echo $r['cid'];?>>
            				<button type = "submit" name = "apply_job" value = <?php echo $r['jid'];?>>Apply</button>
        				</form>
    				</td>
    			<?php else: ?>
    				<td>
    					<p><?php $tmp_row = $tmp_result->fetch_assoc(); echo $tmp_row['result'];?></p>
        			</td>
    			<?php endif?>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
</div>


<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>