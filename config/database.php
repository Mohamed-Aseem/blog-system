<?php
    require 'config/constants.php';
    
    //Connect to the database

    $conn= new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if($conn->connect_error){
        die('Connection Failed: '.$conn->connect_error);
    }
?>