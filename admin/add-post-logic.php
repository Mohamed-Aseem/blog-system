<?php 

session_start();
require './config/database.php';

//Get data if add add post button was clicked
if(isset($_POST['submit'])){
    //Filter to prevent security threats(FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    $author_id = $_SESSION['user_id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    //Set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ? 1:0;

    
    // Validate Inputs Values
    if(!$title){
        $_SESSION['add-post'] = 'Please enter post title';
    } elseif(!$category_id){
        $_SESSION['add-post'] = 'Please select category';
    }elseif(!$body){
        $_SESSION['add-post'] = 'Please enter post body';
    }elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = 'Please choose post thumbnail';
    }else{
        //Works on thumbnail
        //Rename thumbnail
        $time =  time(); // Make each image name unique by using current time
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_temp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/'.$thumbnail_name;
        
        //Make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extention = explode('.', $thumbnail_name);
        $extention = end($extention);

        if(in_array($extention, $allowed_files)){
            //Make sure image is not too large (1mb+)
            if($thumbnail['size']< 2000000){
                // Upload thumbnail
                move_uploaded_file($thumbnail_temp_name, $thumbnail_destination_path);
            }else{
                $_SESSION['add-post'] = 'File size too big. Should be less then 2mb';
            }
        }else{
            $_SESSION['add-post'] = 'File should be png, jpg, or jpeg';
        }
    }
    // Redirect back to add-post page if there was any problem
    if(isset($_SESSION['add-post'])){
        //Pass form data back to add-post page
        $_SESSION['add-post-data'] = $_POST;
        header('location: '. ROOT_URL . 'admin/add-post.php');
        die();
    }else{

        //Set is_featured of all posts to 0 if is_featured for this post is 1
        if($is_featured == 1 ){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = $conn->query($zero_all_is_featured_query);
        }

        //Insert new post into posts table
        $insert_post_query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', $category_id , $author_id , $is_featured)";
        $insert_post_result = $conn->query($insert_post_query);
        if($insert_post_result){
            //Redirect to manage posts page with success message
            $_SESSION['add-post-success'] = "New post added successfully";
            header('location: '. ROOT_URL . 'admin/');
            die();
        }

    }

}else{
    //IF button wasn't clicked, go back to dashboard page
    header('location:' .ROOT_URL . 'admin/add-post.php');
    die();
}

?>