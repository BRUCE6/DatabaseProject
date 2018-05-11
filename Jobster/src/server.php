<?php
    session_start();
    include 'config.php';
    $username = "";
    $name = "";
    $companyname = "";
    
    $errors = array();
    
    $db = mysqli_connect($servername, $db_username, $db_password, $db_name);
    if ($db->connect_error) {
        die("Connection failed");
    }
    // sign up for student
    if (isset($_POST['signup_student']))
    {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $university = mysqli_real_escape_string($db, $_POST['university']);
        $gpa = mysqli_real_escape_string($db, $_POST['gpa']);
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $major = mysqli_real_escape_string($db, $_POST['major']);

        // ensure that form fiels are filled properly
        if (empty($username))
        {
            array_push($errors, "Username is required.");
        }
        if (empty($password))
        {
            array_push($errors, "Password is required.");
        }
        if (empty($name))
        {
            array_push($errors, "Name is required.");
        }
//         if (empty($email))
//         {
//             array_push($errors, "Email is required.");
//         }
        
        // username cannot be used
        if (count($errors) == 0)
        {
            mysqli_query($db, "START TRANSACTION"); 
            $stmt = $db->prepare("SELECT * FROM student WHERE login_name = ? FOR UPDATE");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
//             $sql = "SELECT * FROM student WHERE login_name = '$username' FOR UPDATE";
//             $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                array_push($errors, "Username have already been taken.");
            }
        }
        
        if (count($errors) == 0)
        {
            $password = md5($password); //encrypt password
            $sql = "INSERT INTO student (sname, login_name, password, university, major, GPA) 
                        VALUES ('$name', '$username', '$password', '$university', '$major', '$gpa')";
            mysqli_query($db, $sql);
            mysqli_query($db, "COMMIT");
            $_SESSION["username"] = $username;
            $_SESSION["success"] = "You are now logged in";
            header('location: index_student.php');
        }
    }
    
    // sign up for company
    if (isset($_POST['signup_company']))
    {
        $companyname = mysqli_real_escape_string($db, $_POST['companyname']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        $industry = mysqli_real_escape_string($db, $_POST['industry']);
        //         $username = mysqli_real_escape_string($db, $_POST['username']);
        
        // ensure that form fiels are filled properly
        if (empty($companyname))
        {
            array_push($errors, "Company Name is required.");
        }
        if (empty($password))
        {
            array_push($errors, "Password is required.");
        }
        //         if (empty($email))
            //         {
            //             array_push($errors, "Email is required.");
            //         }
        // ensure company name is not taken
        if (count($errors) == 0)
        {
            mysqli_query($db, "START TRANSACTION"); 
            $stmt = $db->prepare("SELECT cname FROM company WHERE cname = ? FOR UPDATE");
            $stmt->bind_param('s', $companyname);
            $stmt->execute();
            $result = $stmt->get_result();
//             $sql = "SELECT cname FROM company WHERE cname = '$companyname' FOR UPDATE";
//             $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                array_push($errors, "Company name have already been taken.");
                mysqli_query($db, "COMMIT"); 
            }
        }
        
        if (count($errors) == 0)
        {
            $password = md5($password); //encrypt password
            $sql = "INSERT INTO company (cname, password, location, industry)
                        VALUES ('$companyname', '$password', '$location', '$industry')";
            mysqli_query($db, $sql);
            mysqli_query($db, "COMMIT"); 
            $_SESSION["companyname"] = $companyname;
            $_SESSION["success"] = "You are now logged in";
            header('location: index_company.php');
        }
    }
    
    // log student in from login page
    if (isset($_POST['login_student']))
    {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        //         $email = mysqli_real_escape_string($db, $_POST['username']);
        // ensure that form fiels are filled properly
        if (empty($username))
        {
            array_push($errors, "Username is required.");
        }
        if (empty($password))
        {
            array_push($errors, "Password is required.");
        }
        
        if (count($errors) == 0)
        {
            $password = md5($password); // encrypt password
            $stmt = $db->prepare("SELECT * FROM student WHERE login_name = ? AND password = ?");
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
//             $query = "SELECT * FROM student WHERE login_name = '$username' AND password = '$password'";
//             $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 1)
            {
                // log user in
                $_SESSION["username"] = $username;
                $_SESSION["success"] = "You are now logged in";
                header('location: index_student.php');
            }
            else 
            {
                array_push($errors, "wrong username/password");
            }
        }
    }
    
    // log company in from login page
    if (isset($_POST['login_company']))
    {
        $companyname = mysqli_real_escape_string($db, $_POST['companyname']);
        $password = mysqli_real_escape_string($db, $_POST['password']);
        //         $email = mysqli_real_escape_string($db, $_POST['username']);
        // ensure that form fiels are filled properly
        if (empty($companyname))
        {
            array_push($errors, "Company Name is required.");
        }
        if (empty($password))
        {
            array_push($errors, "Password is required.");
        }
        
        if (count($errors) == 0)
        {
            $password = md5($password); // encrypt password
            $stmt = $db->prepare("SELECT * FROM company WHERE cname = ? AND password = ?");
            $stmt->bind_param('ss', $companyname, $password);
            $stmt->execute();
            $result = $stmt->get_result();
//             $query = "SELECT * FROM company WHERE cname = '$companyname' AND password = '$password'";
//             $result = mysqli_query($db, $query);
            if (mysqli_num_rows($result) == 1)
            {
                // log user in
                $_SESSION["companyname"] = $companyname;
                $_SESSION["success"] = "You are now logged in";
                header('location: index_company.php');
            }
            else
            {
                array_push($errors, "wrong username/password");
            }
        }
    }
    
    // logout
    if (isset($_GET['logout']))
    {
        session_destroy();
        unset($_SESSION['username']);
        unset($_SESSION['companyname']);
        header('location: /Jobster/start.html');
    }
    
    
//     Friendship
    if (isset($_POST['cancel_friendship_student']))
    {
        $query = "CALL delete_friend(".$_SESSION['student_id'].",".$_POST['cancel_friendship_student'].");";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
    if (isset($_POST['request_friendship_student']))
    {
        $query = "CALL request_friend(".$_SESSION['student_id'].",".$_POST['request_friendship_student'].");";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
    if (isset($_POST['accept_friendship_student']))
    {
        $query = "CALL answer_friend(".$_POST['accept_friendship_student'].",".$_SESSION['student_id'].",'".$_POST['request_time']."','yes');";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
    if (isset($_POST['decline_friendship_student']))
    {
        $query = "CALL answer_friend(".$_POST['decline_friendship_student'].",".$_SESSION['student_id'].",'".$_POST['request_time']."','no');";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
//     Follow company
    if (isset($_POST['follow']))
    {
        $query = "CALL follow_company(".$_SESSION['student_id'].",".$_POST['follow'].");";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
    if (isset($_POST['unfollow']))
    {
        $query = "CALL unfollow_company(".$_SESSION['student_id'].",".$_POST['unfollow'].");";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
//     Post job
    if (isset($_POST['job_post']))
    {
        $location = mysqli_real_escape_string($db, $_POST['job_location']);
        $title = mysqli_real_escape_string($db, $_POST['job_title']);
        $background = mysqli_real_escape_string($db, $_POST['job_background']);
        $salary = mysqli_real_escape_string($db, $_POST['job_salary']);
        $description = mysqli_real_escape_string($db, $_POST['job_description']);
        date_default_timezone_set('US/Eastern');
        $time = date('Y-m-d H:i:s');
        // ensure that form fiels are filled properly
        if (empty($location))
        {
            array_push($errors, "Location is required.");
        }
        if (empty($title))
        {
            array_push($errors, "Title is required.");
        }
        
        if (count($errors) == 0)
        {
            $query = "CALL post_job(".
                $_SESSION['company_id'].", '$location', '$title', '$salary', '$background', '$description')";
            #echo $query;
            $result = mysqli_query($db, $query);
            header('location: job_company.php');
            
        }
    }

//     Apply job
    if (isset($_POST['apply_job']))
    {
        $query = "CALL apply_job(".$_SESSION['student_id'].",".$_POST['apply_job'].",".$_POST['cid'].");";
        #echo $query;
        $result = mysqli_query($db, $query);
    }
    
// Edit student personal info
    if (isset($_POST['edit_student']))
    {
        $name = mysqli_real_escape_string($db, $_POST['student_name']);
        $university = mysqli_real_escape_string($db, $_POST['student_university']);
        $major = mysqli_real_escape_string($db, $_POST['student_major']);
        $gpa = mysqli_real_escape_string($db, $_POST['student_gpa']);
        $keywords = mysqli_real_escape_string($db, $_POST['student_keywords']);
        // ensure that form fiels are filled properly
        if (empty($name))
        {
            array_push($errors, "Name is required.");
        }
        
        if (count($errors) == 0)
        {
            $query = "UPDATE student SET sname = '$name',university = '$university', major = '$major', gpa = '$gpa', keywords = '$keywords'".
                    " WHERE sid = ".$_SESSION['student_id'];
            #echo $query;
            $result = mysqli_query($db, $query);
            header('location: detail_student.php?detail_student='.$_SESSION['student_id']);
                
        }
    }
    
// Edit Company info
    if (isset($_POST['edit_company']))
    {
        $name = mysqli_real_escape_string($db, $_POST['company_name']);
        $location = mysqli_real_escape_string($db, $_POST['company_location']);
        $industry = mysqli_real_escape_string($db, $_POST['company_industry']);
        // ensure that form fiels are filled properly
        if (empty($name))
        {
            array_push($errors, "Company name is required.");
        }
        
        if (count($errors) == 0)
        {
            mysqli_query($db, "START TRANSACTION"); 
            $sql = "SELECT * FROM company WHERE cname = '$name' FOR UPDATE";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                array_push($errors, "Company name have already been taken.");
                mysqli_query($db, "COMMIT"); 
            }
        }
        
        if (count($errors) == 0)
        {
            $query = "UPDATE company SET cname = '$name', location = '$location', industry = '$industry'".
                " WHERE cid = ".$_SESSION['company_id'];
            #echo $query;
            $result = mysqli_query($db, $query);
            mysqli_query($db, "COMMIT"); 
            $_SESSION['companyname'] = $name;
            header('location: setting_company.php?');
            
        }
    }

    
// Edit Job post
    if (isset($_POST['edit_job']))
    {
        $location = mysqli_real_escape_string($db, $_POST['job_location']);
        $title = mysqli_real_escape_string($db, $_POST['job_title']);
        $background = mysqli_real_escape_string($db, $_POST['job_background']);
        $salary = mysqli_real_escape_string($db, $_POST['job_salary']);
        $description = mysqli_real_escape_string($db, $_POST['job_description']);
        // ensure that form fiels are filled properly
        if (empty($location))
        {
            array_push($errors, "Location is required.");
        }
        if (empty($title))
        {
            array_push($errors, "Title is required.");
        }
        
        if (count($errors) == 0)
        {
            $query = "UPDATE job SET title = '$title', location = '$location', salary = '$salary', background = '$background', description = '$description'".
                " WHERE jid = ".$_POST['job_id'];
            echo $query;
            $result = mysqli_query($db, $query);
            header('location: setting_job.php?job_id='.$_POST['job_id']);
            
        }
    }
    
//     Send message
    if (isset($_POST['message_student']))
    {
        $content = mysqli_real_escape_string($db, $_POST['message_content']);
        date_default_timezone_set('US/Eastern');
        $time = date('Y-m-d H:i:s');
        // ensure that form fiels are filled properly
        if (empty($content))
        {
            array_push($errors, "Content is required.");
        }
        
        
        if (count($errors) == 0)
        {
            $query = "INSERT INTO message VALUES (".$_SESSION['student_id'].",".$_POST['message_to'].",'$time','$content')";
            #echo $query;
            $result = mysqli_query($db, $query);   
        }
    }
    
//     Job checking student number meeting criterion
    $count_number = array();
    if (isset($_POST['job_checknumber']))
    {
        $university = mysqli_real_escape_string($db, $_POST['job_university']);
        $major = mysqli_real_escape_string($db, $_POST['job_major']);
        $gpa = mysqli_real_escape_string($db, $_POST['job_gpa']);
        $keyword1 = mysqli_real_escape_string($db, $_POST['job_keyword1']);
        $keyword2 = mysqli_real_escape_string($db, $_POST['job_keyword2']);
        // ensure that form fiels are filled properly
        if ($gpa == '')
        {
            array_push($errors, "Minimun GPA is required.");
        }
        
        if (count($errors) == 0)
        {
            $query = "SELECT count(*) number FROM student WHERE university LIKE '%$university%' AND major LIKE '%$major%' AND GPA >= $gpa AND keywords like '%$keyword1%' AND keywords like '%$keyword2%'";
            #echo $query;
            $result = mysqli_query($db, $query);
            $r = $result->fetch_assoc();
            array_push($count_number, $r['number']);
        }
    }
    
//     Job broadcast
    $broadcast_state = array();
    if (isset($_POST['job_broadcast']))
    {
        $university = mysqli_real_escape_string($db, $_POST['job_university']);
        $major = mysqli_real_escape_string($db, $_POST['job_major']);
        $gpa = mysqli_real_escape_string($db, $_POST['job_gpa']);
        $keyword1 = mysqli_real_escape_string($db, $_POST['job_keyword1']);
        $keyword2 = mysqli_real_escape_string($db, $_POST['job_keyword2']);
        $jid = $_POST['job_id'];
        date_default_timezone_set('US/Eastern');
        $time = date('Y-m-d H:i:s');
        // ensure that form fiels are filled properly
        if ($gpa == '')
        {
            array_push($errors, "Minimun GPA is required.");
        }
        
        if (count($errors) == 0)
        {
            $query = "INSERT INTO notify_job ".
                "SELECT $jid, sid, '$time', 'unview' FROM student WHERE university LIKE '%$university%' AND major LIKE '%$major%' AND GPA >= $gpa AND keywords like '%$keyword1%' AND keywords like '%$keyword2%'";
            #echo $query;
            $result = mysqli_query($db, $query);
            array_push($broadcast_state, 'success!');
        }
    }
    
//     Job recommend
    $recommend_state = array();
    if (isset($_POST['recommend_job']))
    {
        $sid = $_POST['recommend_to'];
        $jid = $_POST['recommend_job'];
        date_default_timezone_set('US/Eastern');
        $time = date('Y-m-d H:i:s');
        // ensure that form fiels are filled properly
        
        if (count($errors) == 0)
        {
            $query = "INSERT INTO notify_job ".
                "VALUES ($jid, $sid, '$time', 'unview')";
            #echo $query;
            $result = mysqli_query($db, $query);
            array_push($recommend_state, 'success!');
        }
    }
    
//     upload resume
    $resume_errors = array();
    $resume_success = array();
    if (isset($_POST['upload_resume']))
    {
        $name = $_FILES['resume']['name'];
        $type = $_FILES['resume']['type'];
        
        
        if ($type == 'application/pdf')
        {
            $data = file_get_contents($_FILES['resume']['tmp_name']);
            $stmt = $db->prepare("UPDATE student SET resume = ? WHERE sid = ".$_SESSION['student_id']);
            $null = NULL;
            $stmt->bind_param("b", $null);
            $stmt->send_long_data(0, $data); 
            $stmt->execute();
            array_push($resume_success, "Upload successful!");
        }
        else
            array_push($resume_errors, "Please upload a pdf format file.");
    }
?>