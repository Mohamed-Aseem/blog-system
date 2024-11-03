<?php
    session_start();
    require 'config/database.php';

    if(isset($_POST['submit'])){
        $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$username_email){
            $_SESSION['signin'] = 'Plase enter the Username or Email to login';

        }elseif(!$password){
            $_SESSION['signin'] = 'Plase enter your password';
        }else{
            //Fetch user from database
            $fetch_user_query = "SELECT * FROM users WHERE username='{$username_email}' OR email='{$username_email}'";
            $fetch_user_result = $conn->query($fetch_user_query);


            if($fetch_user_result-> num_rows == 1){
                // Convert the record to assoc array
                $user_record = $fetch_user_result->fetch_assoc();
                $db_password = $user_record['password'];
                
                //Compare form password with database password
                if(password_verify($password, $db_password)){
                    //Set session for access control
                    $_SESSION['user_id'] = $user_record['id'];
                    //Set session if user is an admin
                    if($user_record['is_admin'] == 1){
                        $_SESSION['user_is_admin'] = true;
                    }

                    //Log user in
                    header('location: ' . ROOT_URL . 'admin/');
                }else{
                    $_SESSION['signin'] = 'Password is incorrect';
                }
            }else{
                $_SESSION['signin'] = 'User not found';
            }
        }

        //If any problem
        if(isset($_SESSION['signin'])){
            $_SESSION['signin-data'] = $_POST;
            header('location: '. ROOT_URL . 'signin.php');
            die();
        }

    }else{
        header('location: ' . ROOT_URL . 'signin.php');
    }


?>