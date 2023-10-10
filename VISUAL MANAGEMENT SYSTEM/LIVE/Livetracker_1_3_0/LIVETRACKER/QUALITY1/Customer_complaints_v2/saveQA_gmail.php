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
	$Id = (!empty($_POST['id']) ? trim($_POST['id']) : '');
	$stat = (!empty($_POST['status']) ? trim($_POST['status']) : '');
	$comm = (!empty($_POST['comments']) ? trim($_POST['comments']) : '');
  $owner=(!empty($_POST['owner']) ? trim($_POST['owner']) : '');
  $date=(!empty($_POST['date']) ? trim($_POST['date']) : '');
  $action=(!empty($_POST['action']) ? trim($_POST['action']) : '');
  $prev_owner=(!empty($_POST['prev_owner']) ? trim($_POST['prev_owner']) : '');
	$atta="ddd";

  echo($owner);
  //echo($action);
  //echo($stat);
  //echo($prev_owner);
   //to find the email 
if ($owner=='Sean O Brien (Q)')
{
  $query_email="select (t0.firstName + ' ' + t0.lastName)[person], t0.email

   from KENTSTAINLESS.dbo.ohem t0
   
   where t0.Active = 'Y' and t0.email is not NULL and t0.firstName + + ' ' + t0.lastName='$owner'";
}
else{
   $query_email="select (t0.firstName + ' ' + t0.lastName)[person], t0.email

   from KENTSTAINLESS.dbo.ohem t0
   
   where t0.Active = 'Y' and t0.email is not NULL and REPLACE(t0.firstName + t0.lastName, '''', '')='$owner'";
}
   $getResults_email = $conn->prepare($query_email);
   $getResults_email->execute();
   $getResults_email = $getResults_email->fetchAll(PDO::FETCH_BOTH);
  // $query_email["email"];
  foreach ($getResults_email as $row) :
         $email=$row["email"];
                             endforeach;

  /* DATETIME for date_created in MySQL */
  date_default_timezone_set('Europe/Dublin');
  $dateCreated = date("Y-m-d H:i:s", time());
  try {
    //to find the email 

    
    // Array for our insert
		$query=array(':id' => $Id,':stat' => $stat,':atta'=>$atta,':comments' => $comm,':owner' => $email,':action' => $action,':date' => $date,':date_updated' => $dateCreated);
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
  die();
  if ($prev_owner=="no")
  {
  try{

 /*  $mail->SMTPDebug = 3;                               // Enable verbose debug output
	  
  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = 'qualitykentstainless@gmail.com';                 // SMTP username
  $mail->Password = 'ixxozzfinnlffdvj';                           // SMTP password
  $mail->SMTPSecure = 'ssl';                           // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 465;                                    // TCP port to connect to
  $mail->SMTPAuth   = true;
  $mail->setFrom('qualitykentstainless@gmail.com', 'Mailer');
  $mail->addAddress($email, 'ns');     // Add a recipient
               // Name is optional
  $mail->addReplyTo('info@example.com', 'Information');
 // $mail->addCC('cc@example.com');
  //$mail->addBCC('bcc@example.com');
  
 // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
 // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  $mail->isHTML(true);                                  // Set email format to HTML
  
  $mail->Subject = 'MESSAGE FROM QUALITY TEAM';
  $mail->Body    = 'You are the assigned owner of item no '.$Id .'on the Learning Log and it requires your attention. Please click (<a href=http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QUALITY1/non_conformance/non.php>HERE </a> ) here to view and action the item

  .Details on how to action the item can be found in SOP-0679 in PDM<br>

  Kind regards,<br>
  The Quality Team';
 
  
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  
  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
    echo 'Message has been sent';
  } */
}
catch(Exception $e){
  // REPORT ERROR
  die(print_r($e->getMessage()));
}
}
?>