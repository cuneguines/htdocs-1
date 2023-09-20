<?php

try{
    // CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    // CREATE QUERY EXECUTION FUNCTION
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    // REPORT ERROR
    die(print_r($e->getMessage()));
}