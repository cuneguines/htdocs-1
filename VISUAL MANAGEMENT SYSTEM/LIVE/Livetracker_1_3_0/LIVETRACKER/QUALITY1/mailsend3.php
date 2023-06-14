<?php
	  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

	  
	  $mail->SMTPDebug = 3;                               // Enable verbose debug output
	  
	  $mail->isSMTP();                                      // Set mailer to use SMTP
	  $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
	  $mail->SMTPAuth = true;                               // Enable SMTP authentication
	  $mail->Username = 'qualityteam@kentstainless.com';                 // SMTP username
	  $mail->Password = 'jvcjwjhbbtykhmtv';                           // SMTP password
	  $mail->SMTPSecure = 'tls';                           // Enable TLS encryption, `ssl` also accepted
	  $mail->Port = 25;                                    // TCP port to connect to
	  
	  $mail->setFrom('qualityteam@kentstainless.com', 'Mailer');
	  $mail->addAddress('cnixon@kentstainless.com', 'ns');     // Add a recipient
	  //$mail->addAddress('ellen@example.com');               // Name is optional
	  $mail->addReplyTo('info@example.com', 'Information');
	 // $mail->addCC('cc@example.com');
	  //$mail->addBCC('bcc@example.com');
	  
	 // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	 // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	  $mail->isHTML(true);                                  // Set email format to HTML
	  
	  $mail->Subject = 'Here is the subject';
	  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	  
	  if(!$mail->send()) {
		  echo 'Message could not be sent.';
		  echo 'Mailer Error: ' . $mail->ErrorInfo;
	  } else {
		  echo 'Message has been sent';
	  }
	  
  ?>