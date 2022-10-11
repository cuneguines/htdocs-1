<?php

$dataPoints = array(
    array("label" => "Qaulity", "y" => 90),
    array("label" => "Engineering", "y" => 50),
    array("label" => "Plosihing", "y" => 40),
    array("label" => "Customer", "y" => 10),


);
$dataPoints1 = array(
    array("label" => "Qulaity", "symbol" => "Q", "y" => 52.2),
    array("label" => "Engineering", "symbol" => "E", "y" => 26.3),
    array("label" => "Polishing", "symbol" => "Po", "y" => 21.05),
    array("label" => "Customer", "symbol" => "C", "y" => 19),



);

?>


    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "dark1", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Issues in each department 2022",
                    fontSize: 20,
                },
                axisY: {
                    title: "Count"
                },
                axisX: {
                    title: "Department"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            var chart1 = new CanvasJS.Chart("chartContainer1", {
                theme: "dark1",
                animationEnabled: true,
                title: {
                    text: "Percentage",
                    fontSize: 20,
                },
                data: [{
                    type: "doughnut",
                    indexLabel: "{symbol} - {y}",
                    yValueFormatString: "#,##0.0\"%\"",
                    showInLegend: true,
                    legendText: "{label} : {y}",
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
            chart1.render();

        }
    </script>




<div style="margin-left:2%;width:100%;height:100vh;background-color:#eee;">


        <div style="position:relative;border-radius: 10px;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);background-color:#2196f3;height: 15%; width: 20%;float:left;margin-left:4%"><h3>Quality</h3><h1 style="font-weight: bold;position:relative;margin-left:40%;font-size: 35px;">52.2%</h1></div>
        <div style="position:relative;border-radius: 10px;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);background-color:#2196f3;height: 15%; width: 20%;float:left;margin-left:4%"><h3>Engineering</h3><h1 style="font-weight: bold;position:relative;margin-left:40%;font-size: 35px;">26.3%</h1></div>
        <div style="position:relative;border-radius: 10px;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);background-color:#2196f3;height: 15%; width: 20%;float:left;margin-left:4%"><h3>Customer</h3><h1 style="font-weight: bold;position:relative;margin-left:40%;font-size: 35px;">19.0%</h1></div>
        <div style="position:relative;border-radius: 10px;box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);background-color:#2196f3;height: 15%; width: 20%;float:left;margin-left:4%"><h3>Polishing</h3><h1 style="font-weight: bold;position:relative;margin-left:40%;font-size: 35px;">21.2%</h1></div>
  
    
        <div id="chartContainer" style="box-shadow: 0px -10px 10px 0px rgba(0, 0, 0, 0.5);position:relative;height: 53%; width: 44%;float:left;margin-top:2%;margin-left:4%"></div>
        <div id="chartContainer1" style="box-shadow: 0px -5px 10px 0px rgba(0, 0, 0, 0.5);position:relative;height: 53%; width: 44%;float:left;margin-top:2%;margin-left:4%"></div>
    </div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
