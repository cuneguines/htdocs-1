<?php
try{
		// CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
		$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=ENGINEER_HRS","sa","SAPB1Admin");
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
	$Engr_name = (!empty($_POST['nam']) ? $_POST['nam'] : '');
	$project_name= (!empty($_POST['pr_name']) ? $_POST['pr_name'] : '');
	$Sales_order= (!empty($_POST['sales_order']) ? $_POST['sales_order'] : '');
    $Pdm_project= (!empty($_POST['pdm_name']) ? $_POST['pdm_name'] : '');
 
  $date=(!empty($_POST['date']) ? $_POST['date'] : '');
  $Engineer_hours=(!empty($_POST['engr_hrs']) ? $_POST['engr_hrs'] : '');
  $Time_Booked=(!empty($_POST['time_booked']) ? $_POST['time_booked'] : '');
  $Business_name='ss';
	$atta="ddd";
$Time_Booked=5;
  //echo($owner);
  //echo($action);
  //echo($stat);
  //echo($Engineer_hours);
   //to find the email 

  /* DATETIME for date_created in MySQL */
  date_default_timezone_set('Europe/Dublin');
  $dateCreated = date("Y-m-d H:i:s", time());
  try {
    //to find the email 

    
    // Array for our insert
		$query=array(':Date_time' => $dateCreated,':Sales_order' => $Sales_order,':Pdm_project'=>$Pdm_project,':Business_name' => $Business_name,':Project_name' => $project_name,':Engineer_name' => $Engr_name,':Engineer_hours' => $Engineer_hours,':Time_Booked' => $Time_Booked,':date' => $date);
    // Prepare Statement
    $stmt="INSERT INTO dbo.Engrhrs_table01(Date_time,Sales_order,pdm_project,Business_name,Project_name,Engineer_hrs,Time_Booked,Date,Engineer_name)
	VALUES (:Date_time, :Sales_order,:Pdm_project,:Business_name, :Project_name,(CAST(:Engineer_hours AS FLOAT)),:Time_Booked,:date,:Engineer_name)";

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