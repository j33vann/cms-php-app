<?php  include "includes/header.php"; ?>
<?php  include "includes/db.php"; ?>
<?php  include "admin/functions.php"; ?>

<?php  include "includes/navbar.php"; ?>
<?php
// ob_start();
// session_start();

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
        
        
    if(!empty($username) && !empty($user_email) && !empty($user_password)){
        
        $username = mysqli_real_escape_string($connection, $username);
        $user_email = mysqli_real_escape_string($connection, $user_email);
        $user_password = mysqli_real_escape_string($connection, $user_password);
    
        // $hash_query = "SELECT randSalt FROM users";
        // $hash_result = mysqli_query($connection, $hash_query);
        // $row = mysqli_fetch_array($hash_result);
        // $hashedString = $row['randSalt'];
        // $user_password = crypt($user_password, $hashedString);
    
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
    
        $validation_query = "SELECT * FROM users WHERE username='$username'";
        $validation_result = mysqli_query($connection, $validation_query);
        $valid_username = mysqli_num_rows($validation_result);
    
        $validation_query_email = "SELECT * FROM users WHERE user_email='$user_email'";
        $validation_result_email = mysqli_query($connection, $validation_query_email);
        $valid_email = mysqli_num_rows($validation_result_email);
        
        if($valid_username > 0){
            $message = "Username already exists. Already have an account? <a href='./'>Login</a>";
        } else {
            if($valid_email > 0){
                $message = "Email already exists. Already have an account? <a href='./'>Login</a>";
            } else {
                $query = "INSERT INTO users(username, user_email, user_password, user_role) VALUES('$username', '$user_email', '$user_password', 'subscriber')";
                $result = mysqli_query($connection, $query);
                if(!$result){
                    die("something went wrong. " . mysqli_error($connection));
                } else {
                    
                    ///////////////////////// login /////////////////////

                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    
                    $username = mysqli_real_escape_string($connection, $username);
                    $password = mysqli_real_escape_string($connection, $password);
                
                    $query = "SELECT * FROM users WHERE username='{$username}'";
                    $login_result = mysqli_query($connection, $query);
                    if(!$login_result){
                        die("something went wrong");
                    }
                    while($row = mysqli_fetch_assoc($login_result)){
                        $user_id = $row['user_id'];
                        $db_username = $row['username'];
                        $db_password = $row['user_password'];
                        $user_firstname = $row['user_firstname'];
                        $user_lastname = $row['user_lastname'];
                        $user_role = $row['user_role'];
                    }
                
                    if(password_verify($password, $db_password)){
                        
                        $_SESSION['username'] = $db_username;
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['user_firstname'] = $user_firstname;
                        $_SESSION['user_lastname'] = $user_lastname;
                        $_SESSION['user_role'] = $user_role;

                        header("Location: /cms/admin/");
                    } else {
                        header("Location: ../index.php");
                    }
                    ////////////////////// login ////////////////////////////////
                }
            }
        }
        } else {
            $message = "Please fill in all the forms";
        }
} else {
    $message = " ";
}

?>


    <!-- Navigation -->
    
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                <div><?php echo $message; ?></div>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($username) ? $username : '' ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
