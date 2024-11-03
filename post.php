<?php
    include 'partials/header.php';

    //Fetch posts from database if id is set
    if(isset($_GET['id'])){
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT posts.id, posts.title as post_title, posts.body, posts.thumbnail, posts.date_time , categories.id as categories_id, categories.title as category_title, users.firstname, users.lastname, users.avatar FROM posts JOIN users ON posts.author_id = users.id JOIN categories ON posts.category_id = categories.id WHERE posts.id = $id";
        $result = $conn->query($query);
        if($result->num_rows>0){
            $post = $result->fetch_assoc();
        }
    }else{
        header('location: '.ROOT_URL. 'blog.php');
        die();
    }
?>

    <section class="singlepost">
        <div class="container singlepost__container">
            <h2><?= $post['post_title'] ?></h2>
            <div class="post__author">
                <div class="post__author-avatar">
                    <img src="./images/<?= $post['avatar'] ?>" alt="">
                </div>
                <div class="post__author-info single-post">
                    <h5 class="single-post-h5">By: <?= $post['firstname'].' '.$post['lastname'] ?></h5>
                    <small><?= date("M d, Y - H:i", strtotime($post['date_time']))?></small>
                </div>
            </div>
            <div class="singlepost__thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>" alt="">
            </div>
            <p>
                <?=
                    $post['body']
                ?>
            </p>
        </div>
    </section>


    <!---------------------------------------- End of Single Post ---------------------------------------->


<?php
    include 'partials/footer.php';
?>