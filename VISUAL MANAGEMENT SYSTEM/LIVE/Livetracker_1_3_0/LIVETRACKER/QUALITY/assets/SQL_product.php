


<?php include '../../../SQL CONNECTIONS/conn.php'; ?>
<?php
//echo json_encode($_POST);
$item=(!empty($_POST['item'])? $_POST['item'] : 0);
//$item=158962;
/* if (isset($_POST['item'])) {
 echo "This var is set so I will print.";
} */
 //$docnum=158962;
//$item="Product";

try{
    if ($item="PRODUCT")
    {
$delivery_notes="SELECT DISTINCT ISNULL(U_Product_Group_One, 'NO PRODUCT') [PRODUCT] FROM OITM ";

    $getResults = $conn->prepare($delivery_notes);
    $getResults->execute();
    $production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    //$json_array = array();
    //var_dump($production_exceptions_results);
    echo json_encode(array('data'=>$production_exceptions_results));
    }
}
catch(PDOException $e)

{
    echo $e->getMessage();
}  
    ?>
