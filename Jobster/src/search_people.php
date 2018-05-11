<?php $ptitle = "Jobster | People";?>
<?php include 'server.php';
    // if user is not logged in, they cannot access this page
    if (!isset($_POST['people_search']))
    {
        header('location: people_student.php');
    }
?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/head.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/menu_student.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/nav_student.php';?>

<div class = "content">
    <?php 
    if ($_POST['people_university'] == '' and $_POST['people_major'] == ''):
        $query = "SELECT sid, sname, university, major FROM student WHERE sid != ".$_SESSION['student_id'];
    elseif ($_POST['people_university'] == ''):
        $query = "SELECT sid, sname, university, major FROM student WHERE sid != ".$_SESSION['student_id'].
        " AND major LIKE '%".$_POST['people_major']."%'";
    elseif ($_POST['people_major'] == ''):
        $query = "SELECT sid, sname, university, major FROM student WHERE sid != ".$_SESSION['student_id'].
        " AND university LIKE '%".$_POST['people_university']."%'";
    else:
        $query = "SELECT sid, sname, university, major FROM student WHERE sid != ".$_SESSION['student_id'].
        " AND university LIKE '%".$_POST['people_university']."%' AND major LIKE '%".$_POST['people_major']."%'";
    endif;
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
    			
    			<?php 
    			     $tmp_query = "SELECT * FROM friend WHERE sid1 = ".$_SESSION['student_id'].
    			 			" AND sid2 = ".$r['sid'];
    			     #echo $tmp_query;
    			     $tmp_result = mysqli_query($db, $tmp_query);
    			?>
    			<?php if (mysqli_num_rows($tmp_result) == 0): ?>
    				<td>
    					<form method="post" action="people_student.php">
            				<button type = "submit" name = "request_friendship_student" value = <?php echo $r['sid'];?>>Request friendship</button>
        				</form>
        			</td>
        		<?php else:?>
        			<td>
        				<form method="post" action="people_student.php">
            				<button type = "submit" name = "cancel_friendship_student" value = <?php echo $r['sid'];?>>Cancel friendship</button>
        				</form>
    				</td>
        		<?php endif?>
    			<td><a href = detail_student.php?detail_student=<?php echo $r['sid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    

</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>