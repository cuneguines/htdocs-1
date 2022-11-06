<?php
/* if (isset($_POST['item'])) {
	$name = strip_tags($_POST['item']);
	
} */
//echo json_encode(trim($name)); 


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
	$atta="ddd";
  
  /* DATETIME for date_created in MySQL */
  date_default_timezone_set('Europe/Dublin');
  $dateCreated = date("Y-m-d H:i:s", time());
  try {
    // Array for our insert
		$query=array(':id' => $Id,':stat' => $stat,':atta'=>$atta,':comments' => $comm);

    // Prepare Statement
    $stmt="INSERT INTO dbo.Table_2(ID,Status,Attachments,Comments)
	VALUES (:id, :stat,:atta, :comments)";

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
  
  
  
?>