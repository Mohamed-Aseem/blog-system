<?php
    session_start();
    require './config/constants.php';

    //Get back form data if there was a registration error
    $firstname = $_SESSION['signup-data']['firstname'] ?? null;
    $lastname = $_SESSION['signup-data']['lastname'] ?? null;
    $username = $_SESSION['signup-data']['username'] ?? null;
    $email = $_SESSION['signup-data']['email'] ?? null;
    $create_password = $_SESSION['signup-data']['create_password'] ?? null;
    $confirm_password = $_SESSION['signup-data']['confirm_password'] ?? null;

    //Delete signup data
    unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myBlog - App</title>
    <!-- Style Sheet -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- Iconscount CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>

<div class="form__section" style="height: fit-content; padding:2rem 0;">
    <div class="container form__section-container">
        <h2>Sign up</h2>
        <?php if(isset($_SESSION['signup'])):?>
                <div class="alert__message error">
                    <p>
                        <?= 
                            $_SESSION['signup'];
                            unset($_SESSION['signup']);
                        ?>
                    </p>
                </div>
        <?php endif ?>
        <form action="<?php echo ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value='<?= $firstname ?>' placeholder="First Name" >
            <input type="text" name="lastname" value='<?= $lastname ?>' placeholder="Last Name" >
            <input type="text" name="username" value='<?= $username ?>' placeholder="Username" >
            <input type="text" name="email" value='<?= $email?>' placeholder="Email">
            <input type="password" name="create_password" value='<?= $create_password?>' placeholder="Create Password">
            <input type="password" name="confirm_password" value='<?= $confirm_password ?>' placeholder="Confirm Password">
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" id="avatar" name='avatar'>
            </div>
            <button type="submit" class="btn" name='submit'>Sign Up</button>
            <small>Already have an account? <a href="./signin.php">Sign In</a></small>
        </form>
    </div>
</div>

</body>
</html>