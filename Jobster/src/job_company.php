<?php $ptitle = "Jobster | Jobs";?>
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
<?php 
$query = "SELECT jid, title, location FROM job WHERE cid = ".$_SESSION['company_id'];
$result = mysqli_query($db, $query);
?>
<?php if (mysqli_num_rows($result) > 0): ?>
	<table>
		<tr>
			<th>Job Title</th>
			<th>Location</th>
			<th>More</th>
		</tr>
		<?php foreach ($result as $r):?>
		<tr>
			<td><?php echo $r['title'];?></td>
			<td><?php echo $r['location'];?></td>
			<td>
				
				<a href = "setting_job.php?job_id=<?php echo $r['jid'];?>">More</a>
    				
			</td>
		</tr>
		<?php endforeach?>
	</table>
<?php endif?>
</div>

<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>