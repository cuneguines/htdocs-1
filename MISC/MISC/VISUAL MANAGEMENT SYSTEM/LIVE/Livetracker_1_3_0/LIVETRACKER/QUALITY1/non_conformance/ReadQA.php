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
        $results="Select t8.*,FORMAT(CAST(t8.Date AS DATE), 'yyyy-MM-dd') [n_date],t66.person ,t44.attachments from  [LEARNING_LOG].[dbo].[Table_2] t8 
        inner join (select ID,max(date_updated) as Mmaxdate from [LEARNING_LOG].[dbo].[Table_2] group by ID )t6 
        on t8.date_updated =t6.Mmaxdate and t8.ID=$Id

        left join (select (t0.firstName + t0.lastName)[person], t0.email
        
           from KENTSTAINLESS.dbo.ohem t0
           
           where t0.Active = 'Y')t66 on  t66.email COLLATE SQL_Latin1_General_CP1_CI_AS =t8.Owner COLLATE SQL_Latin1_General_CP1_CI_AS
		  left join(select t55.sap_id,t55.created_date,t55.attachments from dbo.attachment_table t55
                    inner join(select t1.sap_id,max(t1.created_date) as Mmaxdate
                    from  dbo.attachment_table t1
					

                     group by t1.sap_id )t66 on t66.Mmaxdate = t55.created_date and t66.sap_id=t55.sap_id)t44 on t44.sap_id = t8.ID and t44.attachments is not NULL";
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