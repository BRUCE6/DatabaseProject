<?php $ptitle = "Jobster | Home";?>
<?php include 'server.php';
    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['companyname']))
    {
        header('location: /Jobster/start.html');
    }
    else
    {
        $query = "SELECT cid FROM company WHERE cname = '".$_SESSION['companyname']."'";
        $result = mysqli_query($db, $query);
        $row = $result->fetch_assoc();
        $_SESSION["company_id"] = $row['cid'];
    }
?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/head.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/menu_company.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/nav_company.php';?>
<div class = "content">
<!-- 	Search box -->
	<form method = "post" action = "search_apply.php">
		<table>
			<tr>
				<th>University</th>
				<td><input type = "text" name = "apply_university"></td>
			</tr>
			<tr>
				<th>Major</th>
				<td><input type = "text" name = "apply_major"></td>
			</tr>
			<tr>
				<th><button type = "submit" name = "apply_search">Search</button></th>
				<td></td>
			</tr>
		</table>
	</form>
<!-- 	Applicants -->
	<h2>All applicants</h2>
	<?php 
    $query = "SELECT J.jid, S.sid, S.sname, S.university, S.major, J.location, J.title, A.time from student S, apply A, job J WHERE ".
        "A.jid = J.jid AND S.sid = A.sid AND J.cid = ".$_SESSION['company_id']." ORDER BY time DESC";
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th width = 30%>Apply time</th>
    			<th>Name</th>
    			<th>University</th>
    			<th>Major</th>
    			<th>Title</th>
    			<th>Location</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['time'];?></td>
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