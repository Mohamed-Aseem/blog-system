<?php
session_start();
require './config/database.php';

//Get signup page data if signup button was clicked
if(isset($_POST['submit'])){
    //Filter to prevent security threats(FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $create_passwod = filter_var($_POST['create_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_passwod = filter_var($_POST['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    
    // Validate Inputs Values
    if(!$firstname){
        $_SESSION['signup'] = 'Please enter your First Name';
    } elseif(!$lastname){
        $_SESSION['signup'] = 'Please enter your Last Name';
    }elseif(!$username){
        $_SESSION['signup'] = 'Please enter your Username';
    }elseif(!$email){
        $_SESSION['signup'] = 'Please enter your valid Email';

    //Check the password length
    }elseif(strlen($create_passwod)<8 || strlen($confirm_passwod) < 8){
        $_SESSION['signup'] = 'Password should be 8+ characters';

    }elseif(!$avatar['name']){
        $_SESSION['signup'] = 'Please select an image';
    }else{
        //Check are the create password and confirm password same 
        if($create_passwod !== $confirm_passwod){
            $_SESSION['signup'] = 'Passwords do not match';
        }else{
            //Hash password for security purpose
            $hashed_password = password_hash($create_passwod,PASSWORD_DEFAULT);

            // Check if username or email already exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email';";
            $user_check_result = $conn->query($user_check_query);
            if($user_check_result -> num_rows > 0){
                $_SESSION['signup'] = 'Username or Email already exist';
            }else{
                //Works on avatar
                //Rename Avatar
                $time =  time(); // Make each image name unique by using current time
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/'.$avatar_name;
                
                //Make sure file is an image
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);

                if(in_array($extention, $allowed_files)){
                    //Make sure image is not too large (1mb+)
                    if($avatar['size']< 1000000){
                        // Upload avatar
                        move_uploaded_file($avatar_temp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['signup'] = 'File size too big. Should be less then 1mb';
                    }
                }else{
                    $_SESSION['signup'] = 'File should be png, jpg, or jpeg';
                }
            }
        }
    }
    // Redirect back to signup page if there was any problem
    if(isset($_SESSION['signup'])){
        //Pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: '. ROOT_URL . 'signup.php');
        die();
    }else{
        //Insert new user into user table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email' ,'$hashed_password', '$avatar_name', 0)";
        $insert_user_ressult = $conn->query($insert_user_query);
        if($insert_user_ressult){
            //Redirect to login page with success message
            $_SESSION['signup-success'] = 'Registration successful. Please login';
            header('location: '. ROOT_URL . 'signin.php');
            die();
        }

    }

}else{
    //IF button wasn't clicked, go back to signup page
    header('location:' .ROOT_URL . 'signup.php');
}

?>