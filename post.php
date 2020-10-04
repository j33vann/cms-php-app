<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/navbar.php"; ?>

<?php



if(isset($_POST['liked'])){
    $select_post_id = $_POST['post_id'];
    $select_user_id = $_POST['user_id'];

    $searchPost = "SELECT * FROM posts WHERE post_id={$select_post_id}";
    $searchPostQuery = mysqli_query($connection, $searchPost);
    $searchPostResult = mysqli_fetch_assoc($searchPostQuery);
    $likes = $searchPostResult['likes'];

    $updateLikes = "UPDATE posts SET likes=$likes + 1 WHERE post_id={$select_post_id}";
    $updateLikesQuery = mysqli_query($connection, $updateLikes);
    
    $insertLikes = "INSERT INTO likes(post_id, user_id) VALUES($select_post_id, $select_user_id)";
    $insertLikesQuery = mysqli_query($connection, $insertLikes);
}

if(isset($_POST['disliked'])){
    $select_post_id = $_POST['post_id'];
    $select_user_id = $_POST['user_id'];

    $searchPost = "SELECT * FROM posts WHERE post_id={$select_post_id}";
    $searchPostQuery = mysqli_query($connection, $searchPost);
    $searchPostResult = mysqli_fetch_assoc($searchPostQuery);
    $likes = $searchPostResult['likes'];

    $updateLikes = "UPDATE posts SET likes=$likes - 1 WHERE post_id={$select_post_id}";
    $updateLikesQuery = mysqli_query($connection, $updateLikes);
    
    $insertLikes = "DELETE FROM likes WHERE post_id={$select_post_id} AND user_id={$select_user_id}";
    $insertLikesQuery = mysqli_query($connection, $insertLikes);
}
?>

    <!-- Navigation -->

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <?php if(isset($_GET['a_id'])){ ?> 
            <h1 class="page-header">
                Posts by author <?php if(isset($_GET['a_id'])){echo $_GET['a_id'];} ?>
            </h1>
            <?php } ?>

            <?php
            if(isset($_GET['a_id'])){
                $get_post_author = $_GET['a_id'];
                $author_query = "SELECT * FROM posts WHERE post_user='$get_post_author' AND post_status='published'";
                $author_result = mysqli_query($connection, $author_query);
                if(!$author_result){
                    die("error: " . mysqli_error($connection));
                } else {
                    while($author_row = mysqli_fetch_assoc($author_result)){
                        $author_post_id = $author_row['post_id'];
                        $author_post_title = $author_row['post_title'];
                        $author_post_author = $author_row['post_user'];
                        $author_post_date = $author_row['post_date'];
                        $author_post_image = $author_row['post_image'];
                        $author_post_content = $author_row['post_content'];
            ?>
                <h2>
                <a href="post.php?p_id=<?php echo $author_post_id ?>"><?php echo $author_post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $author_post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $author_post_date ?></p>
                <hr>
                <!-- <img class="img-responsive" src="images/<?php //echo $author_post_image ?>" alt=""> -->
                <img class="img-responsive" src="images/<?php if(!$author_post_image){ echo "aboutImage-1599529716948.png"; } else { echo $author_post_image; } ?>" alt="Post image">
                <hr>
                <p><?php echo $author_post_content ?></p>
                <hr>
                <?php
                    }
                }
            }
            ?>

            <?php
            
            $query = "SELECT * FROM posts";
            $all_posts_queries = mysqli_query($connection, $query);
            if(isset($_GET['p_id'])){
                $the_post_id = $_GET['p_id'];
                $view_query = "UPDATE posts SET post_view_count=post_view_count + 1 WHERE post_id=$the_post_id";
                $view_result = mysqli_query($connection, $view_query);
            while($row = mysqli_fetch_assoc($all_posts_queries)){
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                if($the_post_id == $post_id){
            ?>
            
           
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="post.php?a_id=<?php echo $post_user ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php if(!$post_image){ echo 'aboutImage-1599529716948.png'; } else { echo $post_image; } ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                
                <?php 
                if(isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];
                }
                if(isset($user_id)){
                $like_query = "SELECT * FROM likes WHERE user_id='{$user_id}' AND post_id='{$the_post_id}'";
                $like_result = mysqli_query($connection, $like_query);
                if(mysqli_num_rows($like_result) < 1){
                ?>
                <div class="row">
                    <p class="pull-right" style="padding-right:10px;" data-toggle="tooltip" data-placement="top" title="Like this post"><a href="" id="like-btn"><i class="fa fa-thumbs-up"></i></span> Like</a></p>
                    <span class="pull-right" onClick="showComment()" style="padding-right:20px;" data-toggle="tooltip" data-placement="top" title="Comment on this post"><a style="cursor: pointer;"><i class="fa fa-comments" aria-hidden="true"></i> Comment </a></span>
                </div>
                <?php } else { ?>
                <div class="row">
                    <p class="pull-right" style="padding-right:10px;" data-toggle="tooltip" data-placement="top" title="dislike this post"><a href="" id="dislike-btn"><i class="fa fa-thumbs-down"></i></span> Dislike</a></p>
                    <span class="pull-right" onClick="showComment()" style="padding-right:20px;" data-toggle="tooltip" data-placement="top" title="Comment on this post"><a style="cursor: pointer;"><i class="fa fa-comments" aria-hidden="true"></i> Comment </a></span>
                </div>
                <?php }
                } else {
                    echo "<p style='font-size: 20px;' data-toggle='tooltip' data-placement='top' title='login'>You need to <a href='login.php'>login</a> to like or comment on this post";
                } 
                ?>
                <div class="row">
                    <?php
                    $num_likes_query = "SELECT * FROM likes WHERE post_id={$the_post_id}";
                    $num_likes_result = mysqli_query($connection, $num_likes_query);
                    $num_likes = mysqli_num_rows($num_likes_result);
                    ?>
                    <p class="pull-right">Likes : <?php echo $num_likes; ?></p>
                </div>
                <div class="clear-fix"></div>
                <?php
                }
                }
            }
            if(isset($_GET['p_id'])){
            ?>
              <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well" id="comment_box">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" id="comment_form">
                        <div class="form-group">
                            <input class="form-control" id="comment_author" name="comment_author" placeholder="Author name">
                        </div>
                        <div class="form-group">
                            <input type="email" id="comment_email" class="form-control" name="comment_email" placeholder="E - mail">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="comment_content" rows="3" name="comment_content" placeholder="Post a comment"></textarea>
                        </div>
                        <button type="submit" id="comment_form_submit_btn" class="btn btn-primary" name="submit_comment">Add comment</button>
                    </form>
                    <?php
                    
                    if(isset($_POST['submit_comment'])){

                        $cmt_post_id = ($_GET['p_id']);

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        $comment_query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES($cmt_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                        $comment_result = mysqli_query($connection, $comment_query);
                        if(!$comment_result){
                            die("something went wrong");
                        }
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){
                        // $add_cmt_query = "UPDATE posts SET post_comment_count=post_comment_count + 1 WHERE post_id={$cmt_post_id}";
                        // $add_cmt_count = mysqli_query($connection, $add_cmt_query);
                        } else {
                            echo "<script>alert('please fill in all the details')</script>";
                        }
                    }
                    
                    ?>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                $cmt_post_id = ($_GET['p_id']);
                
                $cmt_query = "SELECT * FROM comments WHERE comment_status='approved'";
                $cmt_result = mysqli_query($connection, $cmt_query);

                while($row = mysqli_fetch_assoc($cmt_result)){
                    if($row['comment_post_id'] == $cmt_post_id){
                ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $row['comment_author'] ?>
                            <small><?php echo $row['comment_date'] ?></small>
                        </h4>
                        <?php echo $row['comment_content'] ?>                    
                    </div>
                </div>
                <?php 
                    }
                } 
                ?>
                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>
                    <?php } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

<style>
    #comment_box{
        display: none;
    }
</style>
<?php include "includes/footer.php"; ?>


<script>
    $(document).ready(function(){
        var post_id = "<?php echo $the_post_id ?>";
        var user_id = "<?php echo $user_id ?>";

        $("#like-btn").click(function(){
            $.ajax({
                url: "post.php?p_id=" + post_id,
                type: "post",
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
                // success: function(){
                //     alert("it worked");
                // }
            })
        })

        // diislike

        $("#dislike-btn").click(function(){
            $.ajax({
                url: "post.php?p_id=" + post_id,
                type: "post",
                data: {
                    'disliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
                // success: function(){
                //     alert("it worked");
                // }
            })
        })
    })

    function showComment(){
        $("#comment_box").css("display", "block");
    }

    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
</script>