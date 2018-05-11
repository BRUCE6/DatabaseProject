<?php include 'server.php';
// if user is not logged in, they cannot access this page
if (empty($_SESSION['username']) and empty($_SESSION['companyname']))
{
    header('location: /Jobster/start.html');
}
?>
<?php
    
    $query = "SELECT resume FROM student WHERE sid = ".$_GET['resume_id'];
    #echo $query;
    $result = mysqli_query($db, $query);
    $r = $result->fetch_assoc();
    if (!empty($r['resume']))
    {
        header("Content-Type: application/pdf");
        echo $r['resume'];
    }
    else
        echo 'No resume uploaded.';
?>
