<?php
//print_r($_POST['data']);
    if ( $_FILES['file']['error'] > 0 ){
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        if(move_uploaded_file($_FILES['file']['tmp_name'], '../../../../../../QLTYFILES/' . $_FILES['file']['name']))
		{
      $a="C:\\xampp\\htdocs\\ ";
      $x=$_FILES['file']['name'];

      
      echo $x;
      echo"<br>";
      
			echo "File Uploaded Successfully";
      
      try{
      
    $command = escapeshellcmd('C:/Users/cnixon/Python/Python311/python.exe "c:/xampp/htdocs/VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QUALITY1/non_conformance/hello.py"');
    $output = shell_exec($command);
    echo $output;

       
     // echo shell_exec('C:/Users/cnixon/Python/Python311/python.exe "c:/xampp/htdocs/VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QUALITY1/non_conformance/hello.py"');
      

  

      }
      catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
  
        
      }
		}
    }

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
      
   $datastring=(!empty($_POST['data']?$_POST['data']:''));
      /*  if($datastring)
       {
        $datastring=json_decode($datastring);
       } */
        // Get POST data
      //$Id = (!empty($_POST['id']) ? $_POST['id'] : '');
      print_r($datastring);
      $Id=$_POST['data'];
      //$stat = (!empty($_POST['status']) ? $_POST['status'] : '');
      //$comm = (!empty($_POST['comments']) ? $_POST['comments'] : '');
      //$owner=(!empty($_POST['owner']) ? $_POST['owner'] : '');
      //$date=(!empty($_POST['date']) ? $_POST['date'] : '');
      //$action=(!empty($_POST['action']) ? $_POST['action'] : '');
      $atta="ddd";
      
      /* DATETIME for date_created in MySQL */
      date_default_timezone_set('Europe/Dublin');
      $dateCreated = date("Y-m-d H:i:s", time());
      try {
        // Array for our insert
        $query=array(':id' => $Id,':atta'=>$_FILES['file']['name'],':created_date'=>$dateCreated);
    
        // Prepare Statement
        $stmt="INSERT INTO dbo.attachment_table(sap_id,Attachments,created_date)
      VALUES (:id, :atta,:created_date)";
    
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