<?php
    include 'partials/header.php';

    //Fetch categories from database
    $query = "SELECT * FROM categories ORDER BY title";
    $categories = $conn->query($query);


    //Get back form data if there was an error
    $title = $_SESSION['add-post-data']['title'] ?? null;
    $body = $_SESSION['add-post-data']['body'] ?? null;

    //Delete Session data
    unset($_SESSION['add-post-data']);

?>

    <div class="form__section" style="margin-top: 4.1rem;">
        <div class="container form__section-container">
            <h2>Add Post</h2>
            <?php if(isset($_SESSION['add-post'])):?>
                <div class="alert__message error">
                    <p>
                        <?= 
                            $_SESSION['add-post'];
                            unset($_SESSION['add-post']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <select name="category">
                    <?php while($category = $categories->fetch_assoc()):?>
                        <option value="<?= $category['id']?>"><?= $category['title'] ?></option>
                    <?php endwhile ?>
                </select>

                <?php
                    if(isset($_SESSION['user_is_admin'])) :
                ?>
                <div class="form__control inline">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                    <label for="is_featured" style="color: white;">Featured</label>
                </div>

                <?php endif ?>
                <textarea rows="10" placeholder="Body" name="body"><?= $body ?></textarea>
                <div class="form__control">
                    <label for="thumbnail" >Add Thumbnail</label>
                    <input type="file" id="thumbnail" name="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Add Post</button>
            </form>
        </div>
    </div>


<?php
include '../partials/footer.php';
?>