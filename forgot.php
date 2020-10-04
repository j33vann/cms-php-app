<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
if(!isset($_GET['forgotId'])){
    header("Location: index.php");
}

if(isset($_POST['email'])){
    $email =  $_POST['email'];
    $email_query = "SELECT user_email FROM users WHERE user_email='{$email}'";
    $email_result = mysqli_query($connection, $email_query);
    
    if(mysqli_num_rows($email_result) < 1){
        echo "email doesn't exist  in our database";
    } else {
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        if($stmt = mysqli_prepare($connection, "UPDATE users SET token = '{$token}' WHERE user_email = ?")){
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        require_once("PHPMailer-master/src/Exception.php");
        require_once("PHPMailer-master/src/PHPMailer.php");
        require_once("PHPMailer-master/src/SMTP.php");

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->Username = 'jeevanabishek2003@gmail.com';
        $mail->Password = 'jeevan2k19';
        $mail->CharSet = 'UTF-8';
        $mail->SetFrom('jeevanabishek2003@gmail.com', "Jeevan");
        $mail->Subject = "Forgot password";
        $mail->Body = '<p>Please click to reset your password<a href="http://localhost:3000/cms/reset.php?email=' . $email . '&token=' . $token . '">Click here</a></p>';
        $mail->AddAddress($email);
        $mail->isHTML(true);
        // $mail->Send();

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            $success_message =  "Please check your email";
        }

        } else {
            echo "wrong";
        }
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

                                <?php if(!isset($success_message)){ ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                                <?php } else {
                                    echo $success_message;
                                } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

