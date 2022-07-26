
<?php include '../../PHP LIBS/PHP FUNCTIONS/php_function.php';?>
<?php include '../../SQL/CONNECTIONS/conn.php';?>

<?php

/* if (!isset($_POST['item'])) {
echo "xxxxxx";
echo "yyyyyyyyyy";
} */
if (isset($_POST['item'])) {
    //echo "This var is set so I will print.";
}
$item=(!empty($_POST['item'])? $_POST['item'] : 0);
//$item=158962;
//$docnum=158962;


try{
$delivery_notes="SELECT DocNum, CardCode, CardName, DocTotal,CAST(DocDate AS DATE)[DATE], DATEPART(MONTH,DocDate)[MONTH] FROM ORDR WHERE DATEPART(YEAR,DocDate) = 2020 and DocNum=$item";

    $getResults = $conn->prepare($delivery_notes);
    $getResults->execute();
    $production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    //$json_array = array();
    //var_dump($production_exceptions_results);
    echo json_encode(array('data'=>$production_exceptions_results));

}
catch(PDOException $e)

{
    echo $e->getMessage();
}
    ?>