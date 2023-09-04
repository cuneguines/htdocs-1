<!-- Creating JSON FILE FOR Stackedcolumn2d USING PIVOT (SQL) TO create BUSINESS UNITS Chart -->
<?php include '../../PHP LIBS/PHP FUNCTIONS/php_function.php';?>
<?php include '../../SQL/CONNECTIONS/conn.php';?>

<?php
$table_sql = "SELECT t0.DocNum, t0.CardName, t0.Doctotal, t0.OwnerCode, t0.DocDate, DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 WHERE DATEPART(YEAR,DocDate) = 2018";

$graph_sql = "SELECT * FROM
(SELECT t0.DocTotal[DocTotal], t0.OwnerCode, DATEPART(MONTH, t0.DocDate)[MONTH] FROM ORDR t0 WHERE DATEPART(YEAR,DocDate) = 2018)t0
PIVOT(SUM(DocTotal) FOR [MONTH] IN ([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])) AS pivotTable";

// CONN = CONNECTION ()INCLUDE CONNECTION FILE ON LINE 2), SECOND ELEMENT IS YOUR QUERY AS A ASTRING, LAST IS RETURN TYPE (JUST USE 0) 
$table_data = get_sap_data($conn,$table_sql,0);
$graph_data = get_sap_data($conn,$graph_sql,0);

file_put_contents("./table_data.json", json_encode($table_data));


// FORMATTING SQL RESEULTS FOR FSUIN CHARTS API (GRAPHS)
$data_for_fusioncharts = array();
$month_buffer = array();
foreach($graph_data as $row){
    print_r($row["OwnerCode"]);
    for($i = 1 ; $i <= 12; $i++)
    {   
        array_push($month_buffer,array("label" => $i, "value" => $row[$i]));
    }
    array_push($data_for_fusioncharts,array("seriesname" => strtoupper($row["OwnerCode"]), "data" => $month_buffer));
    $month_buffer = array();
}
echo "<br><br>";

file_put_contents("./graph_data.json", json_encode($data_for_fusioncharts));


?>