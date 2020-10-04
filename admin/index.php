<?php include "includes/header.php";?>
    <?php include "includes/navbar.php"; ?>

    <div id="wrapper">
        <!-- Navigation -->

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <?php  ?>

                        <h1 class="page-header">
                            Welcome <?php echo $_SESSION['username']; ?>
                            <span style="font-size: 20px; color: gray;">Role : <?php echo $_SESSION['user_role']; ?></span> 
                        </h1>
                               
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                        $post_query = "SELECT * FROM posts WHERE post_user='{$_SESSION['username']}'";
                        $num_posts = mysqli_query($connection, $post_query);
                        $post_count = mysqli_num_rows($num_posts);
                        echo "<div class='huge'>{$post_count}</div>";
                        ?>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                        $comment_query = "SELECT * FROM comments WHERE comment_author='{$_SESSION['username']}'";
                        $num_comments = mysqli_query($connection, $comment_query);
                        $comment_count = mysqli_num_rows($num_comments);
                        echo "<div class='huge'>{$comment_count}</div>";
                    ?>
                    <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <!-- <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                        // $user_query = "SELECT * FROM users WHERE post_user='{$_SESSION['username']}'";
                        // $num_users = mysqli_query($connection, $user_query);
                        // $user_count = mysqli_num_rows($num_users);
                        // echo "<div class='huge'>{$user_count}</div>";
                    ?>
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div> -->
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <?php
                        $cat_query = "SELECT * FROM categories";
                        $num_categories = mysqli_query($connection, $cat_query);
                        $cat_count = mysqli_num_rows($num_categories);
                        echo "<div class='huge'>{$cat_count}</div>";
                    ?>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->
                    </div>
                </div>
                <div class="row">
                <?php
                $post_query = "SELECT * FROM posts WHERE post_user='{$_SESSION['username']}'";
                $num_posts = mysqli_query($connection, $post_query);
                $post_count = mysqli_num_rows($num_posts);

                $active_post_query = "SELECT * FROM posts WHERE post_status='published' AND post_user='{$_SESSION['username']}'";
                $active_num_posts = mysqli_query($connection, $active_post_query);
                $active_post_count = mysqli_num_rows($active_num_posts);

                $draft_post_query = "SELECT * FROM posts WHERE post_status='draft' AND post_user='{$_SESSION['username']}'";
                $draft_num_posts = mysqli_query($connection, $draft_post_query);
                $draft_post_count = mysqli_num_rows($draft_num_posts);

                $non_comment_query = "SELECT * FROM comments WHERE comment_status='unapproved' AND comment_author='{$_SESSION['username']}'";
                $non_num_comments = mysqli_query($connection, $non_comment_query);
                $non_comment_count = mysqli_num_rows($non_num_comments);

                $approved_comment_query = "SELECT * FROM comments WHERE comment_status='approved' AND comment_author='{$_SESSION['username']}'";
                $approved_num_comments = mysqli_query($connection, $approved_comment_query);
                $approved_comment_count = mysqli_num_rows($approved_num_comments);
                ?>
            <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['data', 'Count'],
            <?php
               $element_text = ['All posts', 'Active posts', 'Draft posts', 'Comments', 'Approved comments', 'Pending comments', 'Categories'];
               $element_count = [$post_count, $active_post_count, $draft_post_count, $comment_count, $approved_comment_count, $non_comment_count, $cat_count];
               for($i=0;$i<7;$i++){
               echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
               }
            ?>
        //   ['2014', 100]
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
        <div id="columnchart_material" style="width: auto; height: 500px;"></div>

                <!-- /.row -->

            </div>
            
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

    <!-- Custom javascript -->
    <script src="js/scripts.js"></script>

</body>

</html>

