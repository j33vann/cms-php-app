<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navbar.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <?php
            
            if(isset($_GET['category'])){
                $the_cat_id = $_GET['category'];
            }

            $cat_query = "SELECT cat_title FROM categories WHERE cat_id={$the_cat_id}";
            $cat_result = mysqli_query($connection, $cat_query);
            while($cat_row = mysqli_fetch_assoc($cat_result)){
                $cat_title = $cat_row['cat_title'];
                echo "<p>Search results for <b>$cat_title</b></p>";
            }

            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id=?");
            } else {
                $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id=? AND post_status=?");
                $published = "published";
            }

            if(isset($stmt1)){
                mysqli_stmt_bind_param($stmt1, "i", $the_cat_id);
                mysqli_stmt_execute($stmt1);
                mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                $stmt = $stmt1;
                $stmt->store_result();
                
            } elseif(isset($stmt2)){
                mysqli_stmt_bind_param($stmt2, "is", $the_cat_id, $published);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
                $stmt = $stmt2;
                $stmt->store_result();
            }

            if($stmt->num_rows === 0){
                echo "<h2>Sorry no results found</h2>";
                // echo $stmt->num_rows;
            }
            
            while(mysqli_stmt_fetch($stmt)){
            ?>
            

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?category=<?php echo $post_category_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo substr($post_content, 0, 50)."..." ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
                }
            ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>
