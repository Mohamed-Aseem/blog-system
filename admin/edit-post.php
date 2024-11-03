<?php
    include 'partials/header.php';

    if(isset($_GET['id'])){
        //Fetch categories from database
        $query = "SELECT * FROM categories ORDER BY title";
        $categories = $conn->query($query);

        //Fetch Old Data
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM posts WHERE id =$id";
        $results = $conn->query($query);
        $post = $results -> fetch_assoc();
    }else{
        header('location: '. ROOT_URL. 'admin/');
    }
?>

    <div class="form__section" style="margin-top: 4.1rem;">
        <div class="container form__section-container">
            <h2>Edit Post</h2>
            <form action="<?=ROOT_URL ?>admin/edit-posts-logic.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $post['id']?>">
                <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
                <input type="text" name="title" value="<?= $post['title']?>" placeholder="Title">
                <select name="category">
                    <?php while($category = $categories->fetch_assoc()):?>
                        <option value="<?= $category['id']?>"><?= $category['title'] ?></option>
                    <?php endwhile ?>
                </select>

                <?php if(isset($_SESSION['user_is_admin'])) :?>
                <div class="form__control inline">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                    <label for="is_featured" style="color: white;">Featured</label>
                </div>

                <?php endif ?>

                <textarea rows="10" name="body" placeholder="Body"><?= $post['body']?></textarea>
                <div class="form__control">
                    <label for="thumbnail" >Change Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" name="submit" class="btn">Update</button>
            </form>
        </div>
    </div>

<?php
include '../partials/footer.php';
?>