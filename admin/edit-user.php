<?php
    include 'partials/header.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM users WHERE id =$id";
        $results = $conn->query($query);
        $user = $results -> fetch_assoc();
    }else{
        header('location: '. ROOT_URL. 'admin/manage-users.php');
    }
?>

    <div class="form__section" style="padding: 5rem 0 2rem;">
        <div class="container form__section-container">
            <h2>Edit User</h2>
            <form action="<?= ROOT_URL?>admin/edit-user-logic.php" method="POST">
                <input type="hidden" value="<?= $id?>" name="id">
                <input type="text" value="<?= $user['firstname']?>" name="firstname" placeholder="First Name">
                <input type="text" value="<?= $user['lastname']?>" name="lastname" placeholder="Last Name">
                <select name="userrole">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <button type="submit" name="submit" class="btn">Update</button>
            </form>
        </div>
    </div>


<?php
include '../partials/footer.php';
?>