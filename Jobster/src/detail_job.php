<?php $ptitle = "Jobster | Job";?>
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
    $query = "SELECT time, location, title, salary, background, description FROM job WHERE jid = ".$_GET['detail_job'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<?php foreach ($result as $r):?>
        		<tr>
        			<th width="20%">Post time</th>
        			<td><?php echo $r['time'];?></td>
        		</tr>
        		<tr>
        			<th>Location</th>
        			<td><?php echo $r['location'];?></td>
        		</tr>
        		<tr>
        			<th>Title</th>
        			<td><?php echo $r['title'];?></td>
        		</tr>
        		<tr>
        			<th>Salary</th>
        			<td><?php echo $r['salary'];?></td>
        		</tr>
        		<tr>
        			<th>Background</th>
        			<td><?php echo $r['background'];?></td>
        		</tr>
        		<tr>
        			<th height = 100>description</th>
        			<td><?php echo $r['description'];?></td>
        		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>