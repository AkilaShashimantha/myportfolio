<?php 

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;


if(isset($_POST["send"])){

$email = $_POST["email"];
$message = $_POST["message"];

$mail = new PHPMailer;
$mail->IsSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'akilashashimantha84@gmail.com';
$mail->Password = 'hcamruxxdjyqufuk';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom($email);
// $mail->addReplyTo('akilashashimantha84@gmail.com', 'Appointment Reciept');
$mail->addAddress('akilashashimantha84@gmail.com', 'mail Send');
$mail->isHTML(true);
$mail->Subject = 'You have New Message From Contact form';
$bodyContent = $message;

$mail->Body    = $bodyContent;

//$mail->send();
if(!$mail->send()){
    echo "<script>alert('Failed to send the email');
    window.location.href = 'index.php';
    </script>";
   

}else{
    echo "<script>alert('Successfully Appointment Details sent the email to $email');
     window.location.href = 'index.php';
    </script>";
    
}

}


?>