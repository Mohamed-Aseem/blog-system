<?php
    include 'partials/header.php';

    //Fetch all posts from post table
    $all_posts_query = "SELECT posts.id, posts.title as post_title, posts.body, posts.thumbnail, posts.date_time , categories.id as categories_id, categories.title as category_title, users.firstname, users.lastname, users.avatar FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id ORDER BY date_time DESC ";
    $all_posts_result = $conn->query($all_posts_query);
?>

    <section class="search__bar">
        <form action="<?= ROOT_URL ?>search.php" class="continer search__bar-container" method="GET">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="search"><path fill="#6563FF" d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z"></path></svg>
                <input type="search" name="search" placeholder="Search">
            </div>
            <button type="submit" name="submit" class="btn">Go</button>
        </form>
    </section>

    <!---------------------------------------- End of Search ---------------------------------------->

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