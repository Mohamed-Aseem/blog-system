<?php
    include 'partials/header.php';

    //Fetch current user's posts from database
    $current_user_id = $_SESSION['user_id'];
    $query = "SELECT posts.id, posts.title as post_title, posts.category_id, categories.title as category_title FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id WHERE posts.author_id= $current_user_id ORDER BY posts.id DESC";
    $posts = $conn->query($query);
?>

<section class="dashboard">

    <?php if(isset($_SESSION['add-post-success'])): // Shows if add post was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['add-post-success'];
                    unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['edit-post-success'])): // Shows if add post was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['edit-post-success'];
                    unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['edit-post'])): // Shows if add post was Not successfull?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['edit-post'];
                    unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['delete-post'])): // Shows if delete post was Not successfull?>
        <div class="alert__message error container">
            <p>
                <?= 
                    $_SESSION['delete-post'];
                    unset($_SESSION['delete-post']);
                ?>
            </p>
        </div>
    <?php elseif(isset($_SESSION['delete-post-success'])): // Shows if delete post was successfull?>
        <div class="alert__message success container">
            <p>
                <?= 
                    $_SESSION['delete-post-success'];
                    unset($_SESSION['delete-post-success']);
                ?>
            </p>
        </div>
    <?php endif?>
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
                    <a href="./index.php" class="active">
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
                        <a href="./manage-categories.php">
                            <i class="fa-solid fa-list-check"></i>
                            <h5>Manage Category</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <?php
                if($posts -> num_rows > 0) :    
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($post = $posts->fetch_assoc()) :?>
                        <tr>
                            <td><?= $post['post_title'] ?></td>
                            <td><?= $post['category_title']?></td>
                            <td><a href='<?= ROOT_URL ?>admin/edit-post.php?id=<?=$post['id']?>' class='btn sm'>Edit</a></td>
                            <td><a href='<?= ROOT_URL ?>admin/delete-post.php?id=<?=$post['id']?>' class='btn sm danger'>Delete</a></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else :?>
                <div class="alert__message error">No posts available</div>
            <?php endif ?>
        </main>
    </div>
</section>

<?php
include '../partials/footer.php';
?>