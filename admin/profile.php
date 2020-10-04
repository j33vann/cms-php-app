<?php include "includes/header.php";?>

    <div id="wrapper">
   
        <!-- Navigation -->
        <?php include "includes/navbar.php"; ?>
        
        <div id="page-wrapper">

            <div class="container-fluid">
            <?php
        
        
        if(!isset($_SESSION['user_role'])){
            echo "<h2 style='text-align: center; padding-top:200px;padding-bottom: 220px;'>You must be <a href='../login.php'>logged in</a> to view this page</h2>";
        } else {
        
        ?>

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <?php 
                        if(isset($_SESSION['username'])){
                            $username = $_SESSION['username']; 
                            $query = "SELECT * FROM users WHERE username='$username'";
                            $user_result = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($user_result)){
                                $user_id = $row['user_id'];
                                $get_username = $row['username'];
                                $get_user_firstname = $row['user_firstname'];
                                $get_user_lastname = $row['user_lastname'];
                                $get_user_email = $row['user_email'];
                                $get_user_role = $row['user_role'];
                                $user_password = $row['user_password'];
                            }
                        }

                        if(isset($_POST['edit_profile'])){
                            $edit_username = $_POST['username'];
                            $edit_firstname = $_POST['user_firstname'];
                            $edit_lastname = $_POST['user_lastname'];
                            $edit_email = $_POST['user_email'];
                            $edit_password = $_POST['user_password'];
                            $edit_password = password_hash($edit_password, PASSWORD_BCRYPT, array('cost' => 10));

                        $edit_query = "UPDATE users SET username='$edit_username', user_firstname='$edit_firstname', user_lastname='$edit_lastname', user_email='$edit_email' ";
                        if(!empty($edit_password)){
                            $edit_query .= ", user_password='$edit_password' ";
                        }
                        $edit_query .= "WHERE user_id='$user_id'";
                        $_SESSION['username'] = $edit_username;
                        $edit_result = mysqli_query($connection, $edit_query);
                        if(!$edit_result){
                            die("something went wrong" . mysqli_error($connection));
                        } else {
                            echo "successfully updated";
                        }
                        header("Location: profile.php");
                        
                        }
                    ?>
                    
<form action="" method="post" enctype= "multipart/form-data">
<div class="form-group">
    <label for="user_firstname">First name</label><br>
    <input class="form-control" name="user_firstname" id="user_firstname" value="<?php echo $get_user_firstname ?>">
    <label for="user_lastname">Last name</label>
    <input class="form-control" type="text" name="user_lastname" value="<?php echo $get_user_lastname ?>">
    <label for="user_role">Role</label>
    <select name="user_role" id="user_role" class="form-control">
        <option><?php echo $get_user_role ?></option>
    </select>
    <label for="username">Username</label>
    <input class="form-control" type="text" name="username" value="<?php echo $get_username ?>">
    <label for="user_email">E - mail</label>
    <input class="form-control" type="text" name="user_email" value="<?php echo $get_user_email ?>">
    <!-- <label for="user_image">user image</label>
    <input type="file" name="user_image"> -->
    <label for="user_password">Password</label>
    <input type="password" class="form-control" type="text" name="user_password">
    <!-- <label for="user_content">user content</label>
    <textarea class="form-control" name="user_content" rows="5"></textarea> -->
    </div>
    <div class="form-group">
    <button class="btn btn-primary" name="edit_profile">Update profile</button>
    </div>
</form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
            <?php } ?>

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
