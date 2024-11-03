<?php
    session_start();
    require 'config/database.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        //update category_id of posts that belong to this category to id of uncategorized category
        $update_query = "UPDATE posts SET category_id = 8 WHERE category_id = $id";
        $update_results = $conn->query($update_query);

        if(!mysqli_errno($conn)){
            //Delete category from database
            $delete_category_query = "DELETE FROM categories WHERE id = $id LIMIT 1";
            $delete_category_result = $conn->query($delete_category_query);
            if(!$delete_category_result){
                $_SESSION['delete-category'] = "Couldn't delete the category";
            }else{
                $_SESSION['delete-category-success'] = "Category deleted successfully";
            }
        }
    }

    header('location: '. ROOT_URL . 'admin/manage-categories.php');
    die();

?>