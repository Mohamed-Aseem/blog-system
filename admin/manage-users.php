<?php
    include 'partials/header.php';
    if(!isset($_SESSION['user_is_admin'])){
        require './config/constants.php';
        header('location: '. ROOT_URL . 'admin/');
    }
    
    //Fetch users from database except the current user(Admin)
    $current_admin_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE NOT id={$current_admin_id}";
    $res = $conn -> query($query);
    
?>

<section class="dashboard">
    <?php if(isset($_SESSION['add-user-success'])): // Shows if add user was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['add-user-success'];
                    unset($_SESSION['add-user-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['edit-user-success'])): // Shows if edit user was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['edit-user-success'];
                    unset($_SESSION['edit-user-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['edit-user'])): // Shows if edit user was failed?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['edit-user'];
                    unset($_SESSION['edit-user']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['delete-user-success'])): // Shows if delete user was success?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['delete-user-success'];
                    unset($_SESSION['delete-user-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['delete-user'])): // Shows if delete user was failed?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['delete-user'];
                    unset($_SESSION['delete-user']);
                ?>
            </p>
        </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="fa-solid fa-arrow-right"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="fa-solid fa-arrow-left"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="./add-post.php">
                        <i class="fa-solid fa-pen"></i>
                        <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="./index.php">
                        <i class="fa-regular fa-pen-to-square"></i>
                        <h5>Manage Post</h5>
                    </a>
                </li>
                <?php if(isset($_SESSION['user_is_admin'])): ?>
                    <li>
                        <a href="./add-user.php">
                            <i class="fa-solid fa-user-plus"></i>
                            <h5>Add User</h5>
                        </a>
                    </li>
                    <li>
                        <a href="./manage-users.php" class="active">
                            <i class="fa-solid fa-users"></i>
                            <h5>Manage Users</h5>
                        </a>
                    </li>
                    <li>
                        <a href="./add-category.php">
                            <i class="fa-solid fa-layer-group"></i>
                            <h5>Add Category</h5>
                        </a>
                    </li>
                    <li>
                        <a href="./manage-categories.php">
                            <i class="fa-solid fa-list-check"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Users</h2>
            <?php
                if($res -> num_rows > 0) :    
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = $res->fetch_assoc()) :?>
                        <tr>
                            <td><?= "{$user['firstname']} {$user['lastname']}"?></td>
                            <td><?= $user['username']?></td>
                            <td><a href='<?= ROOT_URL ?>admin/edit-user.php?id=<?=$user['id']?>' class='btn sm'>Edit</a></td>
                            <td><a href='<?= ROOT_URL ?>admin/delete-user.php?id=<?=$user['id']?>' class='btn sm danger'>Delete</a></td>
                            <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>

            <?php else :?>
                <div class="alert__message error">No users available</div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>