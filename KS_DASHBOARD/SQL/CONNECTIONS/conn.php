<?php
	try
	{
		// INITIATE PDO OBJECT WITH CONNECTION CREDENTIALS
		$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=KENTSTAINLESS","sa","SAPB1Admin");
		// SET ATTRIBUTES
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute( PDO::SQLSRV_ATTR_QUERY_TIMEOUT, 240);
	}
	catch(Exception $e)
	{
		// REPORT ERROR
		die(print_r($e->getMessage()));
	}
?>
	
