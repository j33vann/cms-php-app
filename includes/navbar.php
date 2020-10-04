<?php include "includes/db.php"?>
<?php session_start(); ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">CMS system</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    
                    $query = "SELECT * FROM categories";
                    
                    $all_queries = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($all_queries)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];

                        $category_class = "";
                        
                        $registration_class = "";
                        $contact_class = "";
                        $login_class = "";
                        $registration = "registration.php";
                        $contact = "contact.php";
                        $login = "login.php";

                        $pageName = basename($_SERVER['PHP_SELF']);

                        if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                            $category_class = "active";
                        } elseif($pageName == $registration) {
                            $registration_class = "active";
                        } elseif($pageName == $contact){
                            $contact_class = "active";
                        } elseif($pageName == $login){
                            $login_class = "active";
                        }

                        echo "<li class='$category_class'><a href='category.php?category={$row['cat_id']}'>{$cat_title}</a></li>";
                    }
                    
                    ?>
                    <li class="<?php echo $contact_class ?>">
                        <a href="contact.php">Contact</a>
                    </li>
                    <?php if(isset($_SESSION['user_role'])){ ?>
                    <li>
                        <a href="admin/">Myaccount</a>
                    </li>
                    <li>
                        <a href="includes/logout.php">Logout</a>
                    </li>
                    <?php } else { ?>
                    <li class="<?php echo $registration_class ?>">
                        <a href="registration.php">Register</a>
                    </li>
                    <li class="<?php echo $login_class ?>">
                        <a href="login.php">Login</a>
                    </li>
                    <?php } ?>
                    <!-- <li id='addClassActiveid' onClick="addActiv()">
                        <a href="contact.php" class="">Contact</a>
                    </li> -->
                    <!-- <h1 onClick="addActiv()">asd</h1> -->
                    <?php
                    if(isset($_SESSION['username'])){
                        if(isset($_GET['p_id'])){
                            $the_post_id = $_GET['p_id'];
                            echo 
                            "<li>
                                <a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit post</a>
                            </li>";
                        }
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <script src="js/jquery.js"></script>
    <!-- <script>
        function addActive(){
            alert($(this).attr('class'));
        }
       
        function addActiv(){
            $(this).attr("class", "active");
        }
    </script> -->
