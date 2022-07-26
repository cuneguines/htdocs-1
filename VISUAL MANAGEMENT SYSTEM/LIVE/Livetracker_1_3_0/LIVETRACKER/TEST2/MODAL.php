<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="../../JS/LIBS/jquery-3.4.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../JS/LIBS/jquery-3.4.1.js"></script>
</head>

<body>
    <!-- META STUFF -->
    <meta charset="utf-8">
    <title>Kent Stainless</title>
    <meta name="viewpport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT LIBRARIES -->

    <!-- <script type="text/javascript" src="../../JS/LIBS/jquery-3.4.1.js"></script> -->
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                cache: false
            });
        });
    </script> <!-- DISBLE AJAX CACHING SO THAT IT WILL ALWAYS READ IN JSON FROM LOCAL CACHE INSTEAD OF USING AJAX MEMORY -->
    <?php $table_data = json_decode(file_get_contents("./table_data1.json"), true); ?>


    <!-- STYLESHEET -->
    <link rel="stylesheet" href="../../css/KS_DASH_STYLE.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <script>
        $(document).ready(function() {
            rows = $('table tr').not('.head');
            $.getJSON('./graph_data1.json', function(data) {
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
                            legendItemClicked: function(eventObj, dataObj) {
                                console.log(dataObj.datasetName);
                                console.log(dataObj.visible);

                                if (dataObj.visible === true) {
                                    rows.filter("[ bu = " + dataObj.datasetName + "]").show();
                                } else {
                                    rows.filter("[ bu = " + dataObj.datasetName + "]").hide();
                                }


                            }
                        }
                    }).render();
                });
            });
        });



        function myFunction(event) {
            var CurrentRow = $(event.target).closest("tr");
            // alert(CurrentRow);
            var ItemId = $("td:eq(0)", $(CurrentRow)).html(); // Can Trim also if needed

            var x = ItemId;
            $.ajax({

                type: "POST",
                url: "./get_data_formodal.php",
                data: {
                    'item': x
                },
                dataType: 'json',
                success: function(data) {
                    /* alert("success");
                    console.log(data); */
                    var Documentnumber = 0;
                    var Customer = 0;
                    $.each(data.data, function(i) {
                        $.each(data.data[i], function(key, val) {
                            (key == 'DocNum') ? Documentnumber = val: "";
                            (key == 'CardName') ? Customer = val: ""
                        });

                    });
                    console.log(Documentnumber);
                    console.log(Customer);
                    //$('#employee_detail').html($('<b> Order Id selected: ' + Documentnumber + '</b><b> Customer : ' + Customer + '</b>'));
                    $('#employee_detail').html('<b> Order Id selected: ' + Documentnumber + '</b><br><b> Customer : ' + Customer + '</b>');
                },
            });
        }
    </script>
    <style>

    </style>
    </head>

    <body>
        <div style="height:500px; width:800px; float:left;" id="chart-container4"></div>
        </div>
        
        <div style="height:300px; width:1200px; overflow-y:scroll;">
            <table style="width:100%;">
                <thead>
                    <tr class="dark_grey wtext head" style="position:sticky; top:0;">
                        <th class="lefttext" width="10%">Sales Order</th>
                        <th class="lefttext" width="30%">Customer</th>

                        <th class="lefttext" width="10%">View</th>
                        <th class="lefttext" width="10%">Date</th>
                        <th class="lefttext" width="30%">Month</th>
                        <th class="lefttext" width="10%">total</th>

                    </tr>
                </thead>
                <tbody>
                    <script>
                        console.log(event);
                    </script>
                    <?php foreach ($table_data as $row) : ?>

                        <tr data-target="#dataModal" data-toggle="modal" data-id="<?= strtoupper($row["CardCode"]); ?>" bu="<?= strtoupper($row["CardCode"]); ?>" month="<?= $row["MONTH"] ?>" style="border-bottom:1px solid #454545">
                            <td class="lefttext" style="border-left:1px solid #454545"><?= $row["DocNum"] ?></td>
                            <td class="lefttext" style="border-left:1px solid #454545"><?= $row["CardName"] ?></td>

                            <td class="lefttext" style="border-left:1px solid #454545"><input type="button" name="view" value="view" id="<?php echo $row["DocNum"]; ?>" class="btn btn-info btn-xs view_data" onclick="myFunction(event)" /></td>
                            <td class="lefttext" style="border-left:1px solid #454545"><?= $row["DATE"] ?></td>
                            <td class="lefttext" style="border-left:1px solid #454545"><?= $row["MONTH"] ?></td>
                            <td class="lefttext" style="border-left:1px solid #454545"><?= $row["DocTotal"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div id="dataModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content" id="modal_content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Details</h4>
                    </div>
                    <div class="modal-body" id="employee_detail">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>