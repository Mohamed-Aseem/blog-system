<?php
    include 'partials/header.php';

    //Get back form data if there was an error
    $title = $_SESSION['add-category-data']['title'] ?? null;
    $description = $_SESSION['add-category-data']['description'] ?? null;

    //Delete Session data
    unset($_SESSION['add-category-data']);
?>

    <div class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>
            <?php if(isset($_SESSION['add-category'])):?>
                <div class="alert__message error">
                    <p>
                        <?= 
                            $_SESSION['add-category'];
                            unset($_SESSION['add-category']);
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST">
                <input type="text" value="<?= $title ?>" name="title" placeholder="Title">
                <textarea rows="4" value="<?= $description ?>" name="description" placeholder="Description"></textarea>
                <button type="submit" name="submit" class="btn">Add Category</button>
            </form>
        </div>
    </div>


<?php
include '../partials/footer.php';
?>