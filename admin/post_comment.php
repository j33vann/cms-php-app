<?php include "includes/header.php";?>
<?php include "../includes/db.php";?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navbar.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>In response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Un - approve</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                                <?php
                                
                                $query = "SELECT * FROM comments WHERE comment_post_id=" . mysqli_real_escape_string($connection, $_GET['id']) ."";
                                $result = mysqli_query($connection, $query);

                                if(!$result){
                                    die("something went wrong");
                                }

                                while($row = mysqli_fetch_assoc($result)){
                                    $comment_id = $row['comment_id'];
                                    $comment_post_id = $row['comment_post_id'];
                                    $comment_author = $row['comment_author'];
                                    $comment_content = $row['comment_content'];
                                    $comment_email = $row['comment_email'];
                                    $comment_status = $row['comment_status'];
                                    $comment_date = $row['comment_date'];
                                    // $comment_image = $row['comment_image'];
                                    // $comment_tags = $row['comment_tags'];
                                    // $comment_comments = $row['comment_comment_count'];
                                    
                                ?>
                            <tbody>

                                <td><?php echo $comment_id ?></td>
                                <td><?php echo $comment_author ?></td>
                                <td><?php echo $comment_content ?></td>

                                <td><?php echo $comment_email ?></td>
                                <td><?php echo $comment_status ?></td>
                                <?php
                                $query = "SELECT * FROM posts";
                                $all_posts_queries = mysqli_query($connection, $query);
                                if(!$all_posts_queries){
                                    echo "<script>alert('asd')</script>";
                                }
                                while($row = mysqli_fetch_assoc($all_posts_queries)){
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                    // $post_author = $row['post_author'];
                                    // $post_date = $row['post_date'];
                                    // $post_image = $row['post_image'];
                                    // $post_content = $row['post_content'];
                                    if($comment_post_id == $post_id){
                                ?>
                                <td><?php echo "<a href='../post.php?p_id={$post_id}'>$post_title</a>" ?></td>
                                <?php }} ?>
                                <td><?php echo $comment_date ?></td>
                                <td><?php echo "<a href='comments.php?approve={$comment_id}'>Approve</a>" ?></td>
                                <td><?php echo "<a href='comments.php?unapprove={$comment_id}'>Unapprove</a>" ?></td>
                                <td><?php echo "<a href='post_comment.php?delete={$comment_id}&id={$_GET['id']}'>delete</a>" ?></td>
                                <td><?php echo "<a href='comments.php?source=edit_comment&c_id={$comment_id}'>edit</a>" ?></td>
                                </tbody>
                                <?php 
                                
                                }
                                if(isset($_GET['delete'])){
                                    $the_comment_id = $_GET['delete'];

                                    $query = "DELETE FROM comments WHERE comment_id='$the_comment_id'";

                                    $result = mysqli_query($connection, $query);

                                    if(!$result){
                                        echo "something went wrong. try again";
                                    }

                                    header("Location: post_comment.php?id=" . $_GET['id'] ."");
                                }

                                if(isset($_GET['unapprove'])){
                                    $the_comment_id = $_GET['unapprove'];

                                    $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id='$the_comment_id'";

                                    $result = mysqli_query($connection, $query);

                                    if(!$result){
                                        echo "something went wrong. try again";
                                    }

                                    header("Location: comments.php");
                                }

                                if(isset($_GET['approve'])){
                                    $the_comment_id = $_GET['approve'];

                                    $query = "UPDATE comments SET comment_status='approved' WHERE comment_id='$the_comment_id'";

                                    $result = mysqli_query($connection, $query);

                                    if(!$result){
                                        echo "something went wrong. try again";
                                    }

                                    header("Location: comments.php");
                                }


                                ?>
                        </table>

                        </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom Javascript -->
    <script src="js/scripts.js"></script>

</body>

</html>
