<?php
/* if (isset($_POST['item'])) {
	$name = strip_tags($_POST['item']);
	
} */
//echo json_encode(trim($name)); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception; 

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

	try{
		// CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
		$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG","sa","SAPB1Admin");
		// CREATE QUERY EXECUTION FUNCTION
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e){
		// REPORT ERROR
		die(print_r($e->getMessage()));
	}

    
     
    /* DATETIME for date_created in MySQL */
    // date_default_timezone_set('Europe/Dublin');
    $dateCreated = date("Y-m-d H:i:s", time());
	$modifiedDate = date("Y-m-d H:i:s", time());
	

   
    // Get POST data
	$Id = (!empty($_POST['id']) ? $_POST['id'] : '');
	$stat = (!empty($_POST['status']) ? $_POST['status'] : '');
	$comm = (!empty($_POST['comments']) ? $_POST['comments'] : '');
  $owner=(!empty($_POST['owner']) ? $_POST['owner'] : '');
  $date=(!empty($_POST['date']) ? $_POST['date'] : '');
  $action=(!empty($_POST['action']) ? $_POST['action'] : '');
	$atta="ddd";
  
  /* DATETIME for date_created in MySQL */
  date_default_timezone_set('Europe/Dublin');
  $dateCreated = date("Y-m-d H:i:s", time());
  try {
    // Array for our insert
		$query=array(':id' => $Id,':stat' => $stat,':atta'=>$atta,':comments' => $comm,':owner' => $owner,':action' => $action,':date' => $date,':date_updated' => $dateCreated);

    // Prepare Statement
    $stmt="INSERT INTO dbo.Table_2(ID,Status,Attachments,Comments,Owner,Action,Date,date_updated)
	VALUES (:id, :stat,:atta, :comments,:owner,:action,:date,:date_updated)";

    // Execute Query
  //$stmt->execute($query);
	$getResults = $conn->prepare($stmt);
	$getResults->execute($query);
    if($getResults) {
         echo $conn->lastInsertId();
    } else {
        echo "Error!";
    }

  }

  catch(PDOException $e){
			echo $e->getMessage();
        $e->getMessage();
  }
  try{
  $mail->SMTPDebug = 3;                               // Enable verbose debug output
	  
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = 'cuneguines@gmail.com';                 // SMTP username
  $mail->Password = 'fcurivrxagvixfdc';                           // SMTP password
  $mail->SMTPSecure = 'ssl';                           // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 465;                                    // TCP port to connect to
  $mail->SMTPAuth   = true;
  $mail->setFrom('cuneguines@gmail.com', 'Mailer');
  $mail->addAddress($owner, 'ns');     // Add a recipient
               // Name is optional
  $mail->addReplyTo('info@example.com', 'Information');
 // $mail->addCC('cc@example.com');
  //$mail->addBCC('bcc@example.com');
  
 // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
 // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  $mail->isHTML(true);                                  // Set email format to HTML
  
  $mail->Subject = 'TESTING FROM QUALITY';
  $mail->Body    = $action .' TAKE ACTION NOW!';
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
    echo 'Message has been sent';
  }
}
catch(Exception $e){
  // REPORT ERROR
  die(print_r($e->getMessage()));
}
