<?php $ptitle = "Jobster | Edit";?>
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
	<form method = "post" action="edit_company.php">
	    <!-- display validation errors here -->
		<?php include('errors.php'); ?>
		<?php 
            $query = "SELECT cname, location, industry FROM company WHERE cid = ".$_SESSION['company_id'];
            #echo $query;
            $result = mysqli_query($db, $query);
            $r = $result->fetch_assoc();
        ?>
		<table>
    		<tr>
    			<th width = 40%>Company Name</th>
    			<td><input type = "text" name = "company_name" value = '<?php echo $r['cname']?>'></td>
    		</tr>
    		<tr>
    			<th>Location</th>
    			<td><input type = "text" name = "company_location" value = '<?php echo $r['location']?>'></td>
    		</tr>
    		<tr>
    			<th>Industry</th>
    			<td><input type = "text" name = "company_industry" value = '<?php echo $r['industry']?>'></td>
    		</tr>
    		<tr>
    			<th><button type = "submit" name = "edit_company" class = "btn">Update</button></th>
    			<td></td>
    		</tr>
		</table>
		
	</form>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>