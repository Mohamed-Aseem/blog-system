<?php
    session_start();
    require 'config/database.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        
        //Fetch data of post in order to delete thumbnail from images folder
        $query = "SELECT * FROM posts WHERE id = $id";
        $result = $conn->query($query);

        //make sure only 1 record/post was fetched
        if($result->num_rows == 1){
            $post = $result->fetch_assoc();
            $thumbnail_name = $post['thumbnail'];
            $thumbnail_path = '../images/'.$thumbnail_name;

            //Delete image if available
            if($thumbnail_path){
                unlink($thumbnail_path);

                //Delete post from database
                $delete_post_query = "DELETE FROM posts WHERE id = $id LIMIT 1";
                $delete_post_result = $conn->query($delete_post_query);
                if(!$delete_post_result){
                    $_SESSION['delete-post'] = "Couldn't delete the post";
                }else{
                    $_SESSION['delete-post-success'] = "Post deleted successfully";
                }
            }
        }
    }

    header('location: '. ROOT_URL . 'admin/');
    die();

?>