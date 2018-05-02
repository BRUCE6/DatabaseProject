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
            $sql = "SELECT * FROM student WHERE login_name = '$username'";
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
            $sql = "SELECT * FROM company WHERE cname = '$companyname'";
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
        header('location: start.html');
    }
?>