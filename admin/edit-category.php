<?php
    include 'partials/header.php';

    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

        //Fetch Category from database
        $query = "SELECT * FROM categories WHERE id =$id";
        $results = $conn->query($query);
        if( $results->num_rows == 1){
            $category = $results -> fetch_assoc();
        }
    }else{
        header('location: '. ROOT_URL. 'admin/manage-categories.php');
    }
?>

    <div class="form__section">
        <div class="container form__section-container">
            <h2>Edit Category</h2>
            <form action="<?= ROOT_URL?>admin/edit-category-logic.php" method="POST">
                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                <input type="text" name="title" value="<?=  $category['title']?>" placeholder="Title">
                <textarea rows="4" name="description" placeholder="Description"><?= $category['description']?></textarea>
                <button type="submit" name="submit" class="btn">Update</button>
            </form>
        </div>
    </div>


<?php
    include '../partials/footer.php';
?>