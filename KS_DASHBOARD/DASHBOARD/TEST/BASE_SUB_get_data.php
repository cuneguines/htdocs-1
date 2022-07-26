<?php include '../../PHP LIBS/PHP FUNCTIONS/php_function.php';?>
<?php include '../../SQL/CONNECTIONS/conn.php';?>
<?php include './SQL_test.php'; ?>
<?php

    

    $graph_sql_data = get_sap_data($conn, $sales_per_month_2021_sql,0);
    $json_array = array();

    foreach($graph_sql_data as $month){
        echo $month["MONTH"]." ".$month["Sales"]."<br>";
        array_push($json_array,array("label" => $month["MONTH"], "value" => $month["Sales"]));
    }
    file_put_contents("./CACHE/sales_per_month_2021.json", json_encode($json_array));

    $multi_graph_sql_data_2021 = get_sap_data($conn,$sales_per_month_2021_sql,0);
    $multi_graph_sql_data_2020 = get_sap_data($conn,$sales_per_month_2020_sql,0);
    $multi_graph_sql_data_2019 = get_sap_data($conn,$sales_per_month_2019_sql,0);

    $multi_graph_fusioncharts_data_1 = $multi_graph_fusioncharts_data_2 = $multi_graph_fusioncharts_data_3 = array();

    foreach($multi_graph_sql_data_2021 as $month){
        echo $month["MONTH"]." ".$month["Sales"]."<br>";
        array_push($multi_graph_fusioncharts_data_1,array("label" => $month["MONTH"], "value" => $month["Sales"]));
    }

    foreach($multi_graph_sql_data_2020 as $month){
        echo $month["MONTH"]." ".$month["Sales"]."<br>";
        array_push($multi_graph_fusioncharts_data_2,array("label" => $month["MONTH"], "value" => $month["Sales"]));
    }

    foreach($multi_graph_sql_data_2019 as $month){
        echo $month["MONTH"]." ".$month["Sales"]."<br>";
        array_push($multi_graph_fusioncharts_data_3,array("label" => $month["MONTH"], "value" => $month["Sales"]));
    }

    $sales_per_month_multiseries_fusioncharts_data = array(
        array("seriesname" => "2021", "renderAs" => "spline", "data" => $multi_graph_fusioncharts_data_1),
        array("seriesname" => "2020", "renderAs" => "bar", "data" => $multi_graph_fusioncharts_data_2),
        array("seriesname" => "2019", "renderAs" => "area", "data" => $multi_graph_fusioncharts_data_3)
    );
    file_put_contents("./CACHE/multiseries_sales_per_month.json", json_encode($sales_per_month_multiseries_fusioncharts_data));

    header('Location:BASE_test.php');



?>