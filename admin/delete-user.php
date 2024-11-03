<?php
    session_start();
    require 'config/database.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        //Fetch data of user
        $query = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($query);

        $user = $result->fetch_assoc();

        if($result->num_rows == 1){
            $avatar_name = $user['avatar'];
            $avatar_path = '../images/'.$avatar_name;

            //Delete image if available
            if($avatar_path){
                unlink($avatar_path);
            }
        }

        //For later
        //Fetch all thumbnails of user's posts and delete them
        $thumbnail_query = "SELECT thumbnail FROM posts WHERE author_id = $id";
        $thumbnail_result = $conn->query($thumbnail_query);

        if($thumbnail_result->num_rows>0){
            while($thumbnail = $thumbnail_result->fetch_assoc()){
                $thumbnail_path = '../images/' . $thumbnail['thumbnail'];
                //Delete thumbnail from images folder if exist
                if($thumbnail_path){
                    unlink($thumbnail_path);
                }
            }
        }


        //Delete user from database
        $delete_user_query = "DELETE FROM users WHERE id = $id";
        $delete_user_result = $conn->query($delete_user_query);
        if(!$delete_user_result){
            $_SESSION['delete-user'] = "Couldn't '{$user['firstname']}' delete";
        }else{
            $_SESSION['delete-user-success'] = "User '{$user['firstname']}' deleted successfully";
        }
    }

    header('location: '. ROOT_URL . 'admin/manage-users.php');
    die();

?>