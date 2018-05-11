<?php $ptitle = "Jobster | People";?>
<?php include 'server.php';
    // if user is not logged in, they cannot access this page
    if (empty($_SESSION['companyname']))
    {
        header('location: /Jobster/start.html');
    }

    if (!isset($_GET['info_student']) or empty($_GET['info_student']))
    {
        header('location: index_company.php');
    }
?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/head.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/menu_company.php';?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/nav_company.php';?>
<div class = "content">
    <?php 
    $query = "SELECT sname, university, major, GPA, keywords FROM student WHERE sid = ".$_GET['info_student'];
    #echo $query;
    $result = mysqli_query($db, $query);
    ?>
    <?php if (mysqli_num_rows($result) > 0): ?>
    	<table>
    		<?php foreach ($result as $r):?>
        		<tr>
        			<th width="20%">Name</th>
        			<td><?php echo $r['sname'];?></td>
        		</tr>
        		<tr>
        			<th>University</th>
        			<td><?php echo $r['university'];?></td>
        		</tr>
        		<tr>
        			<th>major</th>
        			<td><?php echo $r['major'];?></td>
        		</tr>
        		<tr>
        			<th>GPA</th>
        			<td><?php echo $r['GPA'];?></td>
        		</tr>
        		<tr>
        			<th>keyword</th>
        			<td><?php echo $r['keywords'];?></td>
        		</tr>
        		<tr>
        			<th>Resume</th>
        			<td>
        				<a target = '_blank' href='view_resume.php?resume_id=<?php echo $_GET['info_student']?>'>link</a>
        			</td>
        		</tr>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>