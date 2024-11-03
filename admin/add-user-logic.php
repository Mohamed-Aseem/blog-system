<?php 

session_start();
require './config/database.php';

//Get data if add user button was clicked
if(isset($_POST['submit'])){
    //Filter to prevent security threats(FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $create_passwod = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_passwod = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    
    // Validate Inputs Values
    if(!$firstname){
        $_SESSION['add-user'] = 'Please enter your First Name';
    } elseif(!$lastname){
        $_SESSION['add-user'] = 'Please enter your Last Name';
    }elseif(!$username){
        $_SESSION['add-user'] = 'Please enter your Username';
    }elseif(!$email){
        $_SESSION['add-user'] = 'Please enter your valid Email';

    //Check the password length
    }elseif(strlen($create_passwod) < 8 || strlen($confirm_passwod) < 8){
        $_SESSION['add-user'] = 'Password should be 8+ characters';

    }elseif(!$avatar['name']){
        $_SESSION['add-user'] = 'Please select an image';
    }else{
        //Check are the create password and confirm password same 
        if($create_passwod !== $confirm_passwod){
            $_SESSION['add-user'] = 'Passwords do not match';
        }else{
            //Hash password for security purpose
            $hashed_password = password_hash($create_passwod,PASSWORD_DEFAULT);

            // Check if username or email already exist in database
            $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email';";
            $user_check_result = $conn->query($user_check_query);
            if($user_check_result -> num_rows > 0){
                $_SESSION['add-user'] = 'Username or Email already exist';
            }else{
                //Works on avatar
                //Rename Avatar
                $time =  time(); // Make each image name unique by using current time
                $avatar_name = $time . $avatar['name'];
                $avatar_temp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/'.$avatar_name;
                
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
                        $_SESSION['add-user'] = 'File size too big. Should be less then 1mb';
                    }
                }else{
                    $_SESSION['add-user'] = 'File should be png, jpg, or jpeg';
                }
            }
        }
    }
    // Redirect back to add-user page if there was any problem
    if(isset($_SESSION['add-user'])){
        //Pass form data back to add-user page
        $_SESSION['add-user-data'] = $_POST;
        header('location: '. ROOT_URL . 'admin/add-user.php');
        die();
    }else{
        //Insert new user into user table
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES ('$firstname', '$lastname', '$username', '$email' ,'$hashed_password', '$avatar_name', '$is_admin')";
        $insert_user_ressult = $conn->query($insert_user_query);
        if($insert_user_ressult){
            //Redirect to login page with success message
            $_SESSION['add-user-success'] = "New user {$firstname} {$lastname} added successfully";
            header('location: '. ROOT_URL . 'admin/manage-users.php');
            die();
        }

    }

}else{
    //IF button wasn't clicked, go back to add-user page
    header('location:' .ROOT_URL . 'admin/add-user.php');
}

?>