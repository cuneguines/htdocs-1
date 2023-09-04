<!DOCTYPE html>
<html>

<head>
    <!-- META STUFF -->
    <meta charset="utf-8">
    <title>Kent Stainless</title>
    <meta name="viewpport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT LIBRARIES -->
    <script type="text/javascript" src="../../JS/LIBS/jquery-3.4.1.js"></script>
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                cache: false
            });
        });
    </script> <!-- DISBLE AJAX CACHING SO THAT IT WILL ALWAYS READ IN JSON FROM LOCAL CACHE INSTEAD OF USING AJAX MEMORY -->
    <?php $table_data = json_decode(file_get_contents("./table_data.json"), true);?>


    <!-- STYLESHEET -->
    <link rel = "stylesheet" href = "../../css/KS_DASH_STYLE.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <script>
        $(document).ready(function(){
            rows = $("table tr:not(':first')");
            console.log(rows);
            $.getJSON('./graph_data.json', function(data) {
            const dataSource = {
                chart: {
                    caption: "Sales",
                    yaxisname: "Value",
                    xaxisname: "Month",
                    subcaption: "2019-2021",
                    showhovereffect: "1",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> of sales were on month $label",
                    theme: "fusion"
                },
                categories: [{
                    category: [{
                            label: "1"
                        },
                        {
                            label: "2"
                        },
                        {
                            label: "3"
                        },
                        {
                            label: "4"
                        },
                        {
                            label: "5"
                        },
                        {
                            label: "6"
                        },
                        {
                            label: "7"
                        },
                        {
                            label: "8"
                        },
                        {
                            label: "9"
                        },
                        {
                            label: "10"
                        },
                        {
                            label: "11"
                        },
                        {
                            label: "12"
                        }
                    ]
                }],
                dataset: data
            };


            FusionCharts.ready(function() {
                var myChart = new FusionCharts({
                    type: "stackedcolumn2d",
                    renderAt: "chart-container4",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource,
                    events: {
                        dataplotClick: function(eventObj, dataObj) {
                            console.log(dataObj.datasetName);
                            console.log(dataObj.categoryLabel);

                           
                            rows.hide()
                            rows.filter("[ bu = " + dataObj.datasetName + "][ month = " + dataObj.categoryLabel + "]").show();
                            


                        },
                        legendItemClicked: function(eventObj, dataObj){
                            console.log(dataObj.datasetName);
                            console.log(dataObj.visible);

                            if(dataObj.visible === true){
                                rows.filter("[ bu = " + dataObj.datasetName + "]").show();
                            }
                            else{
                                rows.filter("[ bu = " + dataObj.datasetName + "]").hide();
                            }


                        }
                    }
                }).render();
            });
        });
        });
    </script>
</head>

<body>
    <div style="height:500px; width:800px; float:left;" id="chart-container4"></div></div>
    <div style="height:300px; width:1200px; overflow-y:scroll;">
        <table style = "width:100%;">
            <thead>
                <tr class = "dark_grey wtext" style = "position:sticky; top:0;">
                    <th width= "10%">Sales Order</th>
                    <th width= "30%">Customer</th>
                    <th width= "10%">Business Unit</th>
                    <th width= "10%">Total</th>
                    <th width= "30%">Due Date</th>
                    <th width= "10%">Month</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($table_data as $row) :?>

                    <tr bu = "<?=strtoupper($row["OwnerCode"]);?>" month = "<?=$row["MONTH"]?>" style = "border-bottom:1px solid #454545">
                        <td><?=$row["DocNum"]?></td>
                        <td><?=$row["CardName"]?></td>
                        <td><?=strtoupper($row["OwnerCode"])?></td>
                        <td ><?=$row["Doctotal"]?></td>
                        <td><?=$row["DocDate"]?></td>
                        <td><?=$row["MONTH"]?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>