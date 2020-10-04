<div class="col-md-4">


                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">
                        <form action="search.php" method="post">
                            <input type="text" name="search" class="form-control">
                            <span class="input-group-btn"> 
                                 <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                             </span>
                        </form>
                    </div>
                </div>
                <?php if(!isset($_SESSION['user_role'])){ ?>
                <!-- login form -->
                <div class="well" style="margin-top: 10px;">
                    <h4>Login</h4>
                    <div class="input-group">
                        <form action="includes/login.php" method="post">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <button name="login" class="btn btn-primary">Login</button>
                            <a href="forgot.php?forgotId=<?php echo uniqid(true); ?>">Forgot password?</a>
                        </form>
                    </div>
                    <!-- /.input-group -->
                </div>
                
                <?php
                } else {
                ?>
                    <div class="well" style="margin-top: 10px;">
                    <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
                    <div class="input-group">
                        <a href="includes/logout.php"><button name="logout" class="btn btn-primary">Logout</button></a>
                    </div>
                </div>
                
                <?php
                }
                ?>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">

                            <?php
                    
                                $query = "SELECT * FROM categories";
                                
                                $all_queries = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($all_queries)){
                                    $cat_title = $row['cat_title'];
                                    $cat_id = $row['cat_id'];
                                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                                }
                            
                            ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>