<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

<!-- Navigation -->
<?php include "includes/navbar.php"; ?>
<?php include "admin/functions.php"; ?>



    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <?php
            if(isset($_SESSION['user_role'])){
                
            if($_SESSION['user_role'] == 'admin'){
                $query = "SELECT * FROM posts";
            } else {
                $query = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            } else {
                $query = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            $query_result = mysqli_query($connection, $query);
            $count_posts = mysqli_num_rows($query_result);
            if($count_posts == 0 || $count_posts < 1){
                echo "<h3 style='text-align: center;'>Sorry no results found</h3>";
            }
            $count = ceil($count_posts/5);

            if(isset($_GET['page'])){
                $page = $_GET['page'];
                // echo "<script>alert('working')</script>";
            } else {
                $page = "";
            }

            if($page == "" || $page == 1){
                $page1 = 0;
            } else {
                $page1 = ($page * 5) - 5;
            }
            if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
                $query = "SELECT * FROM posts LIMIT $page1,5";
            } else {
                $query = "SELECT * FROM posts WHERE post_status='published' LIMIT $page1,5";
            }
            } else {
                $query = "SELECT * FROM posts WHERE post_status='published' LIMIT $page1,5";
            }
            $all_posts_queries = mysqli_query($connection, $query);

            while($row = mysqli_fetch_assoc($all_posts_queries)){
                $post_id = $row['post_id'];

                $post_title = $row['post_title'];
                $post_author = $row['post_user'];    
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
            ?>
                
                
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="post.php?a_id=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php if(!$post_image){ echo "aboutImage-1599529716948.png"; } else { echo $post_image; } ?>" alt="">
                <hr>
                <p><?php echo substr($post_content, 0, 50) . "..." ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
            }
            ?>
               

                <!-- Pager -->
              
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->
            
        <hr>
       
<?php include "includes/footer.php"; ?>
<hr>
<ul class="pager">
    <?php
        pager($count, $page);
    ?>
</ul>
<a href="" id="like-btn">likeeeeeee</a>
