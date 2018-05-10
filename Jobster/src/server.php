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
//         $email = mysqli_real_escape_string($db, $_POST['username']);
        $name = mysqli_real_escape_string($db, $_POST['name']);
//         $username = mysqli_real_escape_string($db, $_POST['username']);

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
            $sql = "SELECT sname FROM student WHERE login_name = '$username'";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                array_push($errors, "Username have already been taken.");
            }
        }
        
        if (count($errors) == 0)
        {
            $password = md5($password); //encrypt password
            $sql = "INSERT INTO student (sname, login_name, password) 
                        VALUES ('$name', '$username', '$password')";
            mysqli_query($db, $sql);
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
            $sql = "SELECT cname FROM company WHERE cname = '$companyname'";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                array_push($errors, "Company name have already been taken.");
            }
        }
        
        if (count($errors) == 0)
        {
            $password = md5($password); //encrypt password
            $sql = "INSERT INTO company (cname, password, location, industry)
                        VALUES ('$companyname', '$password', '$location', '$industry')";
            mysqli_query($db, $sql);
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
            $query = "SELECT * FROM student WHERE login_name = '$username' AND password = '$password'";
            $result = mysqli_query($db, $query);
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
            $query = "SELECT * FROM company WHERE cname = '$companyname' AND password = '$password'";
            $result = mysqli_query($db, $query);
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
            $sql = "SELECT cname FROM company WHERE cname = '$name'";
            $result = mysqli_query($db, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                array_push($errors, "Company name have already been taken.");
            }
        }
        
        if (count($errors) == 0)
        {
            $query = "UPDATE company SET cname = '$name', location = '$location', industry = '$industry'".
                " WHERE cid = ".$_SESSION['company_id'];
            #echo $query;
            $result = mysqli_query($db, $query);
            $_SESSION['companyname'] = $name;
            header('location: setting_company.php?');
            
        }
    }
    
//     Send message
// Edit Company info
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
?>