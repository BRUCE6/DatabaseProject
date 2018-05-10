<?php $ptitle = "Jobster | Company";?>
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
<!-- 	Following company -->
	<h2>Following</h2>
    <?php 
    $query = "SELECT cid, cname, location, industry FROM company WHERE cid IN (SELECT cid FROM follow WHERE sid = ".$_SESSION['student_id'].")";
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Name</th>
    			<th>Location</th>
    			<th>Industry</th>
    			<th>Action</th>
    			<th>More</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['cname'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<td><?php echo $r['industry'];?></td>
    			<?php 
                $tmp_query = "SELECT * FROM follow WHERE sid = ".$_SESSION['student_id']." AND cid = ".$r['cid'];
                #echo $tmp_query;
                $tmp_result = mysqli_query($db, $tmp_query);
                ?>
                <?php if (mysqli_num_rows($tmp_result) > 0): ?>
    				<td>
        				<form method="post" action="company_student.php">
            				<button type = "submit" name = "unfollow" value = <?php echo $r['cid'];?>>Unfollow</button>
        				</form>
    				</td>
    			<?php else: ?>
    				<td>
    					<form method="post" action="company_student.php">
            				<button type = "submit" name = "follow" value = <?php echo $r['cid'];?>>Follow</button>
        				</form>
        			</td>
    			<?php endif?>
    			<td><a href = detail_company.php?detail_company=<?php echo $r['cid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
<!--     Others -->
	<h2>Other Companies</h2>
    <?php 
    $query = "SELECT cid, cname, location, industry FROM company WHERE cid NOT IN (SELECT cid FROM follow WHERE sid = ".$_SESSION['student_id'].")";
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Name</th>
    			<th>Location</th>
    			<th>Industry</th>
    			<th>Action</th>
    			<th>More</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['cname'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<td><?php echo $r['industry'];?></td>
    			<?php 
                $tmp_query = "SELECT * FROM follow WHERE sid = ".$_SESSION['student_id']." AND cid = ".$r['cid'];
                #echo $tmp_query;
                $tmp_result = mysqli_query($db, $tmp_query);
                ?>
                <?php if (mysqli_num_rows($tmp_result) > 0): ?>
    				<td>
        				<form method="post" action="company_student.php">
            				<button type = "submit" name = "unfollow" value = <?php echo $r['cid'];?>>Unfollow</button>
        				</form>
    				</td>
    			<?php else: ?>
    				<td>
    					<form method="post" action="company_student.php">
            				<button type = "submit" name = "follow" value = <?php echo $r['cid'];?>>Follow</button>
        				</form>
        			</td>
    			<?php endif?>
    			<td><a href = detail_company.php?detail_company=<?php echo $r['cid']?>>More</a></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>