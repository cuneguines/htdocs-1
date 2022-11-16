<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



/* Exception class. */
require 'C:\xampp\php\lib\PHPMailer\src\Exception.php';



/* The main PHPMailer class. */
require 'C:\xampp\php\lib\PHPMailer\src\PHPMailer.php';



/* SMTP class, needed if you want to use SMTP. */
require 'C:\xampp\php\lib\PHPMailer\src\SMTP.php';



//require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->Port       = 25;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth   = true;
$mail->Username = 'cnixon@kentstainless.com';
$mail->Password = 'CNks2022??';
$mail->SetFrom('cnixon@kentstainless.com', 'FromEmail');
$mail->addAddress('mcodd@kentstainless.com', 'ToEmail');
//$mail->SMTPDebug  = 3;
//$mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";}; //$mail->Debugoutput = 'echo';
$mail->IsHTML(true);



$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}