<?php
    include 'partials/header.php';

    //Get back form data if there was an error
    $firstname = $_SESSION['add-user-data']['firstname'] ?? null;
    $lastname = $_SESSION['add-user-data']['lastname'] ?? null;
    $username = $_SESSION['add-user-data']['username'] ?? null;
    $email = $_SESSION['add-user-data']['email'] ?? null;
    $create_password = $_SESSION['add-user-data']['createpassword'] ?? null;
    $confirm_password = $_SESSION['add-user-data']['confirmpassword'] ?? null;

    //Delete Session data
    unset($_SESSION['add-user-data']);
?>

    <div class="form__section" style="padding: 5rem 0 2rem; height:fit-content;">
        <div class="container form__section-container">
            <h2>Add User</h2>
            <?php if(isset($_SESSION['add-user'])):?>
                <div class="alert__message error">
                    <p>
                        <?= 
                            $_SESSION['add-user'];
                            unset($_SESSION['add-user']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" value="<?= $firstname ?>" name='firstname' placeholder="First Name">
            <input type="text" value="<?= $lastname ?>" name='lastname' placeholder="Last Name">
            <input type="text" value="<?= $username ?>" name='username' placeholder="Username">
            <input type="text" value="<?= $email ?>" name='email' placeholder="Email">
            <input type="password" value="<?= $create_password ?>" name='createpassword' placeholder="Create Password">
            <input type="password" value="<?= $confirm_password ?>" name='confirmpassword' placeholder="Confirm Password">
            <select name="userrole">
                <option value="0" selected>Author</option>
                <option value="1">Admin</option>
            </select>
            <div class="form__control">
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button name="submit" type="submit" class="btn">Add User</button>
        </form>
        </div>
    </div>

<?php
    include '../partials/footer.php';
?>