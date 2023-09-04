<?php
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
    $Id = (!empty($_POST['id']) ? $_POST['id'] : '');
    try {
        // Array for our insert
        $results="select table_id,Engineer_hours,Engineer_hrs,FORMAT(Date, 'dd-MM-yyyy')[Date],Date_time,Pdm_project,Sales_order,Engineer_name,Project_name from ENGINEER_HRS.dbo.Engrhrs_table01  where Engineer_name='$Id' order by table_id desc";
$getResults = $conn->prepare($results);
$getResults->execute();
$qlty_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//$json_array = array();
//var_dump($production_exceptions_results);
echo json_encode(array($qlty_results));
        
      }
    
      catch(PDOException $e){
                echo $e->getMessage();
            $e->getMessage();
      }