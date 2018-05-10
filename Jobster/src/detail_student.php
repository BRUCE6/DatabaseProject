<?php $ptitle = "Jobster | People";?>
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
    <?php 
    $query = "SELECT sname, university, major, GPA, keywords FROM student WHERE sid = ".$_GET['detail_student'];
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
        		<?php if ($_GET['detail_student'] == $_SESSION['student_id']): ?>
        		<tr>
                	<th><a href = "edit_student.php"><button>Edit</button></a></th>
                	<td></td>
                </tr>
                <?php endif?>
    		<?php endforeach?>
    	</table>
    <?php endif?>
    
</div>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . '/Jobster/src/footer.php';?>