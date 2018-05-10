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
<?php if (isset($_SESSION["companyname"])):?>
	<p>Welcome <strong><?php echo $_SESSION["company_id"];?></strong></p>
	<p><a href="index_company.php?logout='1'" style = "color: red;">Logout</a></p>
<?php endif?>
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>