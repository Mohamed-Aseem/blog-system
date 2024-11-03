<?php 

session_start();
require 'config/database.php';


if(isset($_POST['submit'])){
    //Get form data
    //Filter to prevent security threats(FILTER_SANITIZE_FULL_SPECIAL_CHARS)
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    // Validate Inputs Values
    if(!$title){
        $_SESSION['add-category'] = 'Please enter the title';
    } elseif(!$description){
        $_SESSION['add-category'] = 'Please enter the description';
    }


    // Redirect back to add-category page if there was any problem
    if(isset($_SESSION['add-category'])){
        //Pass form data back to add-category page
        $_SESSION['add-category-data'] = $_POST;
        header('location: '. ROOT_URL . 'admin/add-category.php');
        die();
    }else{
        //Insert new category into categories table
        $insert_category_query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";
        $insert_category_result = $conn->query($insert_category_query);
        if($insert_category_result){
            //Redirect to Manage Categories page with success message
            $_SESSION['add-category-success'] = "New category '{$title}' added successfully";
            header('location: '. ROOT_URL . 'admin/manage-categories.php');
            die();
        }else{
            $_SESSION['add-category'] = "Couldn't add category";
            header('location: '. ROOT_URL . 'admin/add-category.php');
            die();
        }

    }

}else{
    //IF button wasn't clicked, go back to add-user page
    header('location:' .ROOT_URL . 'admin/add-user.php');
}

?>