<?php
    include 'partials/header.php';

    //Fetch posts from database if id is set
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        //Fetch Category title
        $query = "SELECT * FROM categories WHERE id = $id";
        $result_categories = $conn->query($query);
        $post_category = $result_categories->fetch_assoc();

        //Fetch All posts related to the category
        $query_post = "SELECT posts.id, posts.title as post_title, posts.body, posts.thumbnail, posts.date_time , categories.id as categories_id, categories.title as category_title, users.firstname, users.lastname, users.avatar FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id WHERE posts.category_id = $id ORDER BY date_time DESC";
        $result_post = $conn->query($query_post);
    }else{
        header('location: '.ROOT_URL. 'blog.php');
        die();
    }
?>

    <header class="category__title">
        <h2><?= $post_category['title'] ?></h2>
    </header>

    <!---------------------------------------- End of Category Title ---------------------------------------->

    <section class="posts">
        <?php 
            if($result_post->num_rows>0) : ?>
                <div class="container posts__container">
                    <?php while($single_post = $result_post -> fetch_assoc()):?>
                        <article class="post">
                            <div class="post__thumbnail">
                                <img src="./images/<?= $single_post['thumbnail'] ?>" alt="">
                            </div>
                            <div class="post__info">
                                <!-- <a href="./category-posts.php" class="category__button"><?= $single_post['category_title'] ?></a> -->
                                <h3 class="post__title"><a href="post.php?id=<?= $single_post['id'] ?>>"><?= $single_post['post_title'] ?></a></h3>
                                <p class="post__body">
                                    <?= substr($single_post['body'], 0 ,150) ?>...
                                </p>
                                <div class="post__author" style="margin-top: 1rem;">
                                    <div class="post__author-avatar">
                                        <img src="./images/<?= $single_post['avatar'] ?>" alt="">
                                    </div>
                                    <div class="post__author-info">
                                        <h5>By: <?= $single_post['firstname'].' '.$single_post['lastname'] ?></h5>
                                        <small><?= date("M d, Y - H:i", strtotime($single_post['date_time']))?></small>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endwhile ?>
                </div>
            <?php else:?>
                <div class="container alert__message error" style="text-align: center;">
                    <p>No posts available in '<?= $post_category['title'] ?>' category</p>
                </div>
        <?php endif ?>
        
    </section>

    <!---------------------------------------- End of Post ---------------------------------------->



    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php
                $all_categories_query = 'SELECT * FROM categories ORDER BY title';
                $all_categories_result = $conn->query($all_categories_query);
                if($all_categories_result -> num_rows >0) :
                    while($category = $all_categories_result -> fetch_assoc()):
            ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
            <?php
                    endwhile;
                endif;
            ?>
        </div>
    </section>
    <!---------------------------------------- End of Category ---------------------------------------->


    
<?php

include 'partials/footer.php';
?>