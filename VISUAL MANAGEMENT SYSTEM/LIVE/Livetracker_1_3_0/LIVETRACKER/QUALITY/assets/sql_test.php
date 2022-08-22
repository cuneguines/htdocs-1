


<?php include '../../../SQL CONNECTIONS/conn.php'; ?>
<?php
//echo json_encode($_POST);
$item=(!empty($_POST['item'])? $_POST['item'] : 0);

 /* if (isset($_POST['item'])) {
 echo "This var is set so I will print.";
}  */
 //$docnum=158962;
 //$item=165192;

try{
   
$delivery_notes="select * from ORDR where DocNum=$item";

    $getResults = $conn->prepare($delivery_notes);
    $getResults->execute();
    $production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    //$json_array = array();
    //var_dump($production_exceptions_results);
    echo json_encode(array($production_exceptions_results));
    
}
catch(PDOException $e)

{
    echo $e->getMessage();
}  
    ?>
