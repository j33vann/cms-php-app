<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
if($_GET['email'] && $_GET['token']){
    // $email = "jeevanabishek2003@gmail.com";
    // $token = "2b72780e009f6d458fac4d7d5eb5579cfb51cdfd65dec451a5dff8baabdbcd0cdc146420d5ec62f0d2405997913a65da74e4";
    // if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?')){
    //     mysqli_stmt_bind_param($stmt, "s", $token);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_bind_result($stmt, $username, $user_email, $token);
    //     mysqli_stmt_fetch($stmt);
    //     mysqli_stmt_close($stmt);

    //     if($_GET['token'] !== $token || $_GET['email'] !== $email){
    //         header("Location: index.php");
    //     }
    // }
} else {
    header("Location: index.php");
}

if(isset($_POST['password']) && isset($_POST['Confirm-password'])){
    if($_POST['password'] === $_POST['Confirm-password']){
        $email = $_GET['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, array("cost"=>10));
        if($stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '{$hashed_password}' WHERE user_email = ?")){
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_affected_rows($stmt) >= 1){
                header("Location: login.php");
            } else {
                echo "<script>alert('it was not affected')</script>";
            }
        } else {
            echo "bad query";
        }
    } else {
        echo "passwords not equal";
    }
}
?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <input id="password" name="password" placeholder="password" class="form-control"  type="password">
                                            <input id="Confirm-password" name="Confirm-password" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <h2>Please check your email</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

