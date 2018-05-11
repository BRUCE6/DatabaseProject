<?php $ptitle = "Jobster | My Info";?>
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
    $query = "SELECT cname, location, industry FROM company WHERE cid = ".$_SESSION['company_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    $r = $result->fetch_assoc();
    ?>
    
	<table>
		<tr>
			<th width = 40%>Company Name</th>
			<td><?php echo $r['cname'];?></td>
		</tr>
		<tr>
			<th>Location</th>
			<td><?php echo $r['location'];?></td>
		</tr>
		<tr>
			<th>Industry</th>
			<td><?php echo $r['industry'];?></td>
		</tr>
		<tr>
			<th>
    			<form action = "edit_company.php">
    				<button type = "submit">Edit</button>
    			</form>
			</th>
            <td></td>
		</tr>
	</table>
    
    
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>