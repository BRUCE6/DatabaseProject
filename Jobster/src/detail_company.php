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
<?php if (isset($_SESSION["username"])):?>
	<?php 
    $query = "SELECT cname, location, industry FROM company WHERE cid = ".$_GET['detail_company'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Company</th>
    			<th>Location</th>
    			<th>Industry</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['cname'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<td><?php echo $r['industry'];?></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    <h2>Jobs</h2>
    <?php 
    $query = "SELECT title, location, time FROM job WHERE cid = ".$_GET['detail_company'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<tr>
    			<th>Title</th>
    			<th>Location</th>
    			<th>Posted time</th>
    		</tr>
    		<?php foreach ($result as $r):?>
    		<tr>
    			<td><?php echo $r['title'];?></td>
    			<td><?php echo $r['location'];?></td>
    			<td><?php echo $r['time'];?></td>
    		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>