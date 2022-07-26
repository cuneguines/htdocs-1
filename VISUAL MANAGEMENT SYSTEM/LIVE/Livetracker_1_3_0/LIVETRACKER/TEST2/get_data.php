<!-- Creating JSON FILE FOR Stackedcolumn2d USING PIVOT (SQL) TO create BUSINESS UNITS Chart -->
<?php include '../../PHP LIBS/PHP FUNCTIONS/php_function.php';?>
<?php include '../../SQL/CONNECTIONS/conn.php';?>

<?php
$table_sql = "SELECT t0.DocNum, t0.CardName, t0.Doctotal, t0.U_Dimension1, t0.DocDate, DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 WHERE DATEPART(YEAR,DocDate) = 2018";

$graph_sql = "SELECT * FROM
(SELECT t0.DocTotal[DocTotal], t0.U_Dimension1, DATEPART(MONTH, t0.DocDate)[MONTH] FROM ORDR t0 WHERE DATEPART(YEAR,DocDate) = 2018)t0
PIVOT(SUM(DocTotal) FOR [MONTH] IN ([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12])) AS pivotTable";

// CONN = CONNECTION ()INCLUDE CONNECTION FILE ON LINE 2), SECOND ELEMENT IS YOUR QUERY AS A ASTRING, LAST IS RETURN TYPE (JUST USE 0) 
$table_data = get_sap_data($conn,$table_sql,0);
$graph_data = get_sap_data($conn,$graph_sql,0);

file_put_contents("./table_data.json", json_encode($table_data));


// FORMATTING SQL RESEULTS FOR FSUIN CHARTS API (GRAPHS)
$data_for_fusioncharts = array();
$month_buffer = array();
foreach($graph_data as $row){
   // print_r($row["U_Dimension1"]);
    for($i = 1 ; $i <= 12; $i++)
    {   
        array_push($month_buffer,array("label" => $i, "value" => $row[$i]));
    }
    array_push($data_for_fusioncharts,array("seriesname" => strtoupper($row["U_Dimension1"]), "data" => $month_buffer));
    $month_buffer = array();
}
echo "<br><br>";

file_put_contents("./graph_data.json", json_encode($data_for_fusioncharts));


$table_sql1 = "SELECT DocNum, CardCode, CardName, DocTotal,CAST(DocDate AS DATE)[DATE], DATEPART(MONTH,DocDate)[MONTH] FROM ORDR WHERE DATEPART(YEAR,DocDate) = 2020";
$graph_sql1 = "SELECT * FROM (SELECT t0.CardCode, t0.DocTotal, DATEPART(MONTH,t0.DocDate)[MONTH] FROM ORDR t0 
RIGHT JOIN (SELECT TOP 10 t0.CardCode,SUM(t0.DocTotal)[SUM]FROM ORDR t0 WHERE DATEPART(YEAR,t0.DocDate) = 2020 GROUP BY t0.CardCode ORDER BY [SUM] DESC) t1 on t1.CardCode = t0.CardCode WHERE DATEPART(YEAR,t0.DocDate) = 2020)t0
PIVOT(SUM(t0.DocTotal) FOR [MONTH] IN ([1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11],[12]))AS pivotTable";


// CONN = CONNECTION ()INCLUDE CONNECTION FILE ON LINE 2), SECOND ELEMENT IS YOUR QUERY AS A ASTRING, LAST IS RETURN TYPE (JUST USE 0) 
$table_data1 = get_sap_data($conn,$table_sql1,0);
$graph_data1 = get_sap_data($conn,$graph_sql1,0);

file_put_contents("./table_data1.json", json_encode($table_data1));


// FORMATTING SQL RESEULTS FOR FSUIN CHARTS API (GRAPHS)
$data_for_fusioncharts1 = array();
$month_buffer1 = array();
foreach($graph_data1 as $row){
   print_r($row["CardCode"]);
    for($i = 1 ; $i <= 12; $i++)
    {   
        array_push($month_buffer1,array("label" => $i, "value" => $row[$i]));
    }
    array_push($data_for_fusioncharts1,array("seriesname" => strtoupper($row["CardCode"]), "data" => $month_buffer1));
    $month_buffer1 = array();
}
echo "<br><br>";

file_put_contents("./graph_data1.json", json_encode($data_for_fusioncharts1));

?>