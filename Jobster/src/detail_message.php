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
    <?php 
    $query = "SELECT * FROM ((SELECT M.from_sid, M.to_sid, M.time, M.content, S.sname FROM message M, student S WHERE S.sid = M.to_sid AND M.from_sid = ".$_SESSION['student_id']." AND M.to_sid = ".$_POST['message_to'].")".
                " UNION (SELECT M.from_sid, M.to_sid, M.time, M.content, S.sname FROM message M, student S WHERE S.sid = M.from_sid AND M.to_sid = ".$_SESSION['student_id']." AND M.from_sid = ".$_POST['message_to'].")) t".
                " ORDER BY time";
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>From</th>
    			<th>To</th>
    			<th>Content</th>
    			<th>Time</th>
    		<?php foreach ($result as $r):?>
        		<tr>
        			<td>
        				<?php 
        				if ($r['from_sid'] == $_SESSION['student_id']):
        				    echo 'Me';
        				else:
        				    echo $r['sname'];
        			    endif
        				?>
         			</td>
         			<td>
         				<?php 
        				if ($r['to_sid'] == $_SESSION['student_id']):
        				    echo 'Me';
        				else:
        				    echo $r['sname'];
        			    endif
        				?>
         			</td>
        			<td><?php echo $r['content']?></td>
        			<td><?php echo $r['time']?></td>
        		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     Compose message -->
	<h2>Compose message</h2>
	<form method = "post" action="detail_message.php">
		<input type = "hidden" name = "message_to" value = <?php echo $_POST['message_to']?>>
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<table>
    		<tr>
    			<th width = 20%, height = 200>Message</th>
    			<td><textarea name = "message_content" rows = 10 cols= 50></textarea></td>
    		</tr>
    		<tr>
    			<th><button type = "submit" name = "message_student" class = "btn">Send</button></th>
    			<td></td>
    		</tr>
		</table>
	</form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>