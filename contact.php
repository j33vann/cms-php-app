<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- <?php  //include "private.env"; ?> -->


<?php

if(isset($_POST['submit'])){

$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

require_once("PHPMailer-master/src/Exception.php");
require_once("PHPMailer-master/src/PHPMailer.php");
require_once("PHPMailer-master/src/SMTP.php");

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Host = 'smtp.gmail.com';
$mail->Port = '465';
$mail->IsHTML();
$mail->Username = 'jeevanabishek2003@gmail.com';
$mail->Password = 'jeevan2k19';
$mail->CharSet = 'UTF-8';
$mail->SetFrom('jeevanabishek2003@gmail.com', "Jeevan");
$mail->Subject = $subject;
$mail->Body = $message;
$mail->AddAddress($email);

// $mail->Send();

   if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
   } else {
      echo "Message has been sent";
   }

}

// require("PHPMailer-master/src/PHPMailer.php");
// require("PHPMailer-master/src/SMTP.php");

//   $mail = new PHPMailer\PHPMailer\PHPMailer();
//   $mail->IsSMTP(); // enable SMTP

//   $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
//   $mail->SMTPAuth = true; // authentication enabled
//   $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
//   $mail->Host = "smtp.gmail.com";
//   $mail->Port = 465; // or 587
//   $mail->IsHTML(true);
//   $mail->Username = "jeevanabishek2003@gmail.com";
//   $mail->Password = "jeevan2k19";
//   $mail->SetFrom("jeevanabishek2003@gmail.com");
//   $mail->Subject = "Test";
//   $mail->Body = "hello";
//   $mail->AddAddress("jeevanabishek2003@gmail.com");

//    if(!$mail->Send()) {
//       echo "Mailer Error: " . $mail->ErrorInfo;
//    } else {
//       echo "Message has been sent";
//    }

?>


    <!-- Navigation -->
    
    <?php  include "includes/navbar.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                        </div>
                         <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea class="form-control" name="message" id="" cols="30" rows="10" placeholder="Enter your message"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
