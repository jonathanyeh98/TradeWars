<?php

    session_start();

    $username = "";
    $email = "";
    $errors = array();

    //connect to database
    $db = new mysqli('localhost','root','','users');
    
    //if session user creates league
    if (isset($_POST['create_league_final'])){
        $league_name = $db->real_escape_string($_POST['league_name']);
        $league_starting_balance = $db->real_escape_string($_POST['league_starting_balance']);
    
        //ensure that form fields are filled properly
        if(empty($league_name)){
            array_push($errors,"Name is required");
        }
        if(empty($league_starting_balance)){
            array_push($errors,"Starting Balance is required");
        }
        //if no errors, save league settings to database
        if (count($errors) == 0){
            
            $sql = "select * from usertable where (username = '".$_SESSION['username']."')";
            $result = mysqli_query($db,$sql);
            $row_user = mysqli_fetch_row($result);
            $user_id = $row_user[0];
            $sql1 = "insert into leaguetable (user_id,league_name,league_starting_balance) values ('$user_id','$league_name','$league_starting_balance')";
            $query = mysqli_query($db,$sql1);
            //$sql2 = "select * from leaguetable where (league_name = '.$league_name.')";
            //$query2 = mysqli_query($db,$sql2);
            //$row_league = mysqli_fetch_row($query2);
            //$league_id = $row_league[0];
            
            $sql3 = "insert into playertable (user_id, league_id,balance) values ('$user_id',LAST_INSERT_ID(),'$league_starting_balance')";
            $query3 = mysqli_query($db,$sql3);
            if ($query and $query3){
                $_SESSION['success'] = 'You have created a league!!';
                header('location: index.php'); //redirects to logged in page
                exit();
            }else{
                array_push($errors, "Something terrible happened.");
            }
            }
    
        }
    //if the register button is clicked
    if (isset($_POST['register'])){
        $username = $db->real_escape_string($_POST['username']);
        $email = $db->real_escape_string($_POST['email']);
        $password_1 = $db->real_escape_string($_POST['password_1']);
        $password_2 = $db->real_escape_string($_POST['password_2']);

        // ensure that form fields are filled properly
        if (empty($username)){
            array_push($errors, "Username is required");
        }
        if (empty($email)){
            array_push($errors, "Email is required");
        }
        if (empty($password_1)){
            array_push($errors, "Password is required");
        }
        if ($password_1 != $password_2){
            array_push($errors, "Passwords do not match");
        }

        // if there are no errors, save user to database
        if (count($errors) == 0){
            $password = md5($password_1); //encryption for security
            $sql = "INSERT INTO usertable (username, email, password) VALUES ('$username','$email','$password')";
            mysqli_query($db,$sql);
            
            $_SESSION['username'] = $username;
            $_SESSION['success'] = 'You are now logged in';
            header('location: index.php'); //redirects to logged in page
            exit();
        }
    }

    //login user from login page
    if (isset($_POST['login'])){
        $username = $db->real_escape_string($_POST['username']);
        $password = $db->real_escape_string($_POST['password']);

        // ensure that form fields are filled properly
        if (empty($username)){
            array_push($errors, "Username is required");
        }
        if (empty($password)){
            array_push($errors, "Password is required");
        }
        if(count($errors)==0){
            $password = md5($password); //encrypt before comparing
            $query = "select * from usertable where username = '$username' and password = '$password'";
            $result = mysqli_query($db,$query);
            if (mysqli_num_rows($result) == 1){
                //log user in 
                $_SESSION['username'] = $username;
                $_SESSION['success'] = 'You are now logged in';
                header('location: index.php');
                exit();
            }else{
                array_push($errors, "Wrong username/password combination");
            }
        }
    }
    	//update user info
        if (isset($_POST['updateaccount'])){
            $newemail = $db->real_escape_string($_POST['newemail']);
            $password_old = $db->real_escape_string($_POST['password_old']);
            $password_new_1 = $db->real_escape_string($_POST['password_new_1']);
            $password_new_2 = $db->real_escape_string($_POST['password_new_2']);
            // ensure that form fields are filled properly
            if (empty($password_old)){
                array_push($errors, "Old password is required");
            }
            if ($password_new_1 != $password_new_2){
                array_push($errors, "New passwords must match");
            }
            if(count($errors)==0){
                $username = $_SESSION['username'];
                $password_old = md5($password_old); //encrypt before comparing
                $query = "select * from usertable where username = '$username' and password = '$password_old'";
                $result = mysqli_query($db,$query);
                if (mysqli_num_rows($result) == 1){
                    if(!empty($newemail))
                    {
                        $query = "update usertable set email = '$newemail' where username = '$username' and password = '$password_old'";
                        mysqli_query($db,$query);
                    }
                    if(!empty($password_new_1))
                    {
                        $password_new_1 = md5($password_new_1);
                        $query = "update usertable set password = '$password_new_1' where username = '$username' and password = '$password_old'";
                        mysqli_query($db,$query);
                    }
                    $_SESSION['success'] = 'Successfully updated account information';
                }else{
                    array_push($errors, "Old password incorrect");
                }
            }
        }
    //logout
    if (isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        header('location: homepage.php');
    }
?>