<?php
session_start();
require 'config/database.php';

if(isset($_POST['submit']))
    //Get updated form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //Check for valid input
    if(!$title || !$description){
        $_SESSION['edit-category'] = 'Invalid form input on edit category page';
    }else{
        //Update category
        $query = "UPDATE categories SET title = '$title', description = '$description' WHERE id = $id LIMIT 1";
        $result = $conn -> query($query);
        if($result){
            $_SESSION['edit-category-success']= 'Category data updated successfully';
        }else{
            $_SESSION['edit-category']= 'Failed to update category';
        }
    }


    header('location: '.ROOT_URL . 'admin/manage-categories.php');
    die();
?>