<?php $ptitle = "Jobster | Home";?>
<?php include 'server.php';
    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['username']))
    {
        header('location: /Jobster/start.html');
    }
    else
    {
        $query = "SELECT sid FROM student WHERE login_name = '".$_SESSION['username']."'";
        $result = mysqli_query($db, $query);
        $row = $result->fetch_assoc();
        $_SESSION["student_id"] = $row['sid'];
    }
?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/head.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/menu_student.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/nav_student.php';?>
<div class = "content">
<?php if (isset($_SESSION["username"])):?>
	<p>Welcome <strong><?php echo $_SESSION["student_id"];?></strong></p>
	<h2>Jobs from following companies</h2>
	<?php 
    $query = "SELECT C.cname, J.title ,J.location, J.time FROM job J, company C, follow F WHERE F.cid = J.cid AND J.cid = C.cid AND F.sid = ".$_SESSION['student_id']." ORDER BY J.time DESC";
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
			<th>Company</th>
			<th>Job Title</th>
			<th>Location</th>
			<th>Post time</th>
		</tr>
		<?php foreach ($result as $r):?>
		<tr>
			<td><?php echo $r['cname'];?></td>
			<td><?php echo $r['title'];?></td>
			<td><?php echo $r['location'];?></td>
			<td><?php echo $r['time'];?></td>
		</tr>
		<?php endforeach?>
    	</table>
    <?php endif?>
	<p><a href="index_student.php?logout='1'" style = "color: red;">Logout</a></p>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>