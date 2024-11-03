<?php
session_start();
require 'config/database.php';

if(isset($_POST['submit'])){
    $is_featured = null;
    //Get updated form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    if(isset($_POST['is_featured'])){
        $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    }
    $thumbnail = $_FILES['thumbnail'];

    
    //Set is_featured to 0 if unchecked
    $is_featured = $is_featured == 1 ? 1:0;

     // Validate Inputs Values
    if(!$title){
        $_SESSION['edit-post'] = 'Please enter post title';
    } elseif(!$category_id){
        $_SESSION['edit-post'] = 'Please select category';
    }elseif(!$body){
        $_SESSION['edit-post'] = 'Please enter post body';
    }else{
        //Delete existing thumbnail if new thumbnail is available
        if($thumbnail['name']){
            $previous_thumbnail_path ='../images/' . $previous_thumbnail_name;
            if($previous_thumbnail_path){
                unlink($previous_thumbnail_path);
            }

            //Works on new thumbnail
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
                    $_SESSION['edit-post'] = 'File size too big. Should be less then 2mb';
                }
            }else{
                $_SESSION['edit-post'] = 'File should be png, jpg, or jpeg';
            }
        }
    }
    
    if($_SESSION['edit-post']){
        header('location: ' . ROOT_URL . 'admin/');
        die();    
    }else{
        //Set is_featured of all posts to 0 if is_featured for this post is 1
        if($is_featured == 1 ){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = $conn->query($zero_all_is_featured_query);
        }

        //Set thumbnail name if a new one was uploaded, else keep old thumbnail name
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        //Update post
        $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_to_insert', category_id = $category_id, is_featured= $is_featured WHERE id = $id LIMIT 1";
        $result = $conn -> query($query);
        if($result){
            $_SESSION['edit-post-success']= 'Post data updated successfully';
        }else{
            $_SESSION['edit-post']= 'Failed to update post';
        }


        header('location: '.ROOT_URL . 'admin/');
        die();
    }
}else{
    header('location: '.ROOT_URL . 'admin/');
    die();
}
    
?>