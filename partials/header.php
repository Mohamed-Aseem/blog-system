<?php
    session_start();
    require 'config/database.php';

     //Fetch data of current user from database
     if(isset($_SESSION['user_id'])){
        $id = filter_var($_SESSION['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $user_avatar_query = "SELECT avatar FROM users WHERE id={$id}";
        $results = $conn -> query($user_avatar_query);
        $avatar = $results->fetch_assoc();
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myBlog - App</title>
    <!-- Style Sheet -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Iconscount CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>

<body>
    <nav>
        <div class="container nav__container">
            <a href="<?php echo ROOT_URL ?>" class="nav__logo">myBlog</a>
            <ul class="nav__items">
                <li><a href="<?php echo ROOT_URL ?>">Home</a></li>
                <li><a href="<?php echo ROOT_URL ?>blog.php">Blogs</a></li>
                <li><a href="<?php echo ROOT_URL ?>contact.php">Contact</a></li>
                <?php if(!isset($_SESSION['user_id'])) : ?>
                <li><a href="<?php echo ROOT_URL ?>signin.php">Sign-In</a></li>
                <?php elseif(isset($_SESSION['user_id'])): ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="Avatar">
                    </div>
                    <ul>
                        <li><a href="<?php echo ROOT_URL ?>admin/index.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL ?>logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php endif?>
            </ul>
            <button id="open__nav-btn"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" id="bars">
                    <path fill="#6563FF" d="M20,11H4c-0.6,0-1,0.4-1,1s0.4,1,1,1h16c0.6,0,1-0.4,1-1S20.6,11,20,11z M4,8h16c0.6,0,1-0.4,1-1s-0.4-1-1-1H4C3.4,6,3,6.4,3,7S3.4,8,4,8z M20,16H4c-0.6,0-1,0.4-1,1s0.4,1,1,1h16c0.6,0,1-0.4,1-1S20.6,16,20,16z"></path>
                </svg></button>
            <button id="close__nav-btn"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" id="multiply">
                    <path fill="#6563FF" d="M13.4,12l6.3-6.3c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L12,10.6L5.7,4.3c-0.4-0.4-1-0.4-1.4,0c-0.4,0.4-0.4,1,0,1.4l6.3,6.3l-6.3,6.3C4.1,18.5,4,18.7,4,19c0,0.6,0.4,1,1,1c0.3,0,0.5-0.1,0.7-0.3l6.3-6.3l6.3,6.3c0.2,0.2,0.4,0.3,0.7,0.3s0.5-0.1,0.7-0.3c0.4-0.4,0.4-1,0-1.4L13.4,12z"></path>
                </svg></button>
        </div>
    </nav>

    <!---------------------------------------- End of Nav ---------------------------------------->