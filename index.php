<?php
    include 'partials/header.php';
    $featured= null;
    //Fetch featured post from database
    $featured_query = "SELECT posts.id, posts.title as post_title, posts.body, posts.thumbnail, posts.date_time , categories.id as categories_id, categories.title as category_title, users.firstname, users.lastname, users.avatar FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id WHERE is_featured = 1";
    $featured_result = $conn->query($featured_query);
    if($featured_result -> num_rows>0){
        $featured = $featured_result -> fetch_assoc();
    }

    //Fetch 9 posts from post table
    $all_posts_query = "SELECT posts.id, posts.title as post_title, posts.body, posts.thumbnail, posts.date_time , categories.id as categories_id, categories.title as category_title, users.firstname, users.lastname, users.avatar FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id WHERE NOT is_featured = 1 ORDER BY date_time DESC LIMIT 9";
    $all_posts_result = $conn->query($all_posts_query);
?>

<!-- show featured post if there was any -->
<?php if($featured_result -> num_rows >0) : ?>

    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="./images/<?= $featured['thumbnail']?>" alt="">
            </div>
            <div class="post__info">

                <a href="<?= ROOT_URL?>category-posts.php?id=<?= $featured['categories_id'] ?>>" class="category__button"><?= $featured['category_title'] ?></a>
                <h2 class="post__title">
                    <a href="post.php?id=<?= $featured['id']?>"><?= $featured['post_title'] ?></a>
                </h2>
                <p class="post__body">
                    <?= substr($featured['body'], 0,300) ?>...
                </p>
                <div class="post__author" style="margin-top: 1rem;">
                    <div class="post__author-avatar">
                        <img src="./images/<?= $featured['avatar']?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= $featured['firstname'].' '.$featured['lastname'] ?></h5>
                        <small><?= date("M d, Y - H:i", strtotime($featured['date_time']))?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif ?>
    <!---------------------------------------- End of Featured Post ---------------------------------------->

    <section class="posts <?=  $featured ? '' : 'section__extra-margin'?>">
        <div class="container posts__container">
            <?php if($all_posts_result->num_rows>0):?>
                <?php while($post =  $all_posts_result->fetch_assoc()): ?>
                    <article class="post">
                        <div class="post__thumbnail">
                            <img src="./images/<?= $post['thumbnail']?>" alt="">
                        </div>
                        <div class="post__info">
                            <a href="./category-posts.php" class="category__button"><?= $post['category_title'] ?></a>
                            <h3 class="post__title"><a href="post.php?id=<?= $post['id'] ?>>"><?= $post['post_title'] ?></a></h3>
                            <p class="post__body">
                                <?= substr($post['body'], 0 ,150) ?>...
                            </p>
                            <div class="post__author" style="margin-top: 1rem;">
                                <div class="post__author-avatar">
                                    <img src="./images/<?= $post['avatar'] ?>" alt="">
                                </div>
                                <div class="post__author-info">
                                    <h5>By: <?= $post['firstname'].' '.$post['lastname'] ?></h5>
                                    <small><?= date("M d, Y - H:i", strtotime($post['date_time']))?></small>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile ?>
            <?php else:?>
                <div class="alert__message error">
                    <p>No posts available</p>
                </div>
            <?php endif ?>
        </div>
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