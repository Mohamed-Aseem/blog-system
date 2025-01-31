<?php
    include 'partials/header.php';
     
    if(!isset($_SESSION['user_is_admin'])){
        require './config/constants.php';
        header('location: '. ROOT_URL . 'admin/');
    }

    //Fetch categories from database
    $query = "SELECT * FROM categories ORDER BY title";
    $categories = $conn -> query($query);
    
?>

<section class="dashboard">
    <?php if(isset($_SESSION['add-category-success'])): // Shows if add category was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['add-category-success'];
                    unset($_SESSION['add-category-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['add-category'])): // Shows if add category was Not successful?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['edit-category'])): // Shows if edit category was Not successfull?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['edit-category'];
                    unset($_SESSION['edit-category']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['edit-category-success'])): // Shows if edit category was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['edit-category-success'];
                    unset($_SESSION['edit-category-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['delete-category-success'])): // Shows if Delete category was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['delete-category-success'];
                    unset($_SESSION['delete-category-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['delete-category'])): // Shows if Delete category was Not successfull?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['delete-category'];
                    unset($_SESSION['delete-category']);
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
                        <a href="./manage-users.php">
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
                        <a href="./manage-categories.php" class="active">
                            <i class="fa-solid fa-list-check"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <?php if($categories->num_rows>0):?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($category = $categories->fetch_assoc()) :?>
                        <tr>
                            <td><?= $category['title'] ?></td>
                            <td><a href="<?=ROOT_URL?>admin/edit-category.php?id=<?= $category['id']?>" class="btn sm">Edit</a></td>
                            <td><a href="<?=ROOT_URL?>admin/delete-category.php?id=<?= $category['id']?>" class="btn sm danger">Delete</a></td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else:?>
                <div class="alert__message error">No categories found</div>
            <?php endif?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>