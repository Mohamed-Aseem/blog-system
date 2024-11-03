<?php
    require 'partials/header.php';

    if(isset($_GET['submit']) && $_GET['search']!= null && $_GET['search']!= ''){
        $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $query = "SELECT posts.id, posts.title as post_title, posts.body, posts.thumbnail, posts.date_time , categories.id as categories_id, categories.title as category_title, users.firstname, users.lastname, users.avatar FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id WHERE posts.title LIKE '%$search%' ORDER BY date_time DESC";
        $posts = $conn->query($query);

    }else{
        header('location: '. ROOT_URL. 'blog.php');
    }

?>

<section class="posts section__extra-margin">
        <div class="container">
            <h2 style="color: #0f0f3e; margin:100px 0 30px;">Search Results of '<?= $_GET['search'] ?>'</h2>
        </div>
        <div class="container posts__container">
            <?php if($posts -> num_rows >0):?>
                <?php while($post =  $posts->fetch_assoc()): ?>
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
    require 'partials/footer.php';
?>