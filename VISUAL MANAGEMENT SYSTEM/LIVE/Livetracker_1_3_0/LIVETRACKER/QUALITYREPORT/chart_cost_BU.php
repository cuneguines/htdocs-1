<!DOCTYPE html>
<html>
<head>
    <!-- Include Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Business Unit');
            data.addColumn('number', 'Cost');
            data.addRows([
                ['DR', 156],
                ['ST', 2569],
                ['Int', 2469],
                ['BPSP', 3464],
                ['BPBP', 2647],
                ['MB', 3467]
            ]);

            // Set chart options
            var options = {
                title: 'Cost by Business Unit',
                chartArea: {width: '50%'},
                hAxis: {
                    title: 'Cost',
                    minValue: 0
                },
                vAxis: {
                    title: 'Business Unit'
                }
            };

            // Instantiate and draw the chart.
            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
     <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        #chart_div {
            width: 800px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
        }
        h2 {
            margin: 10px 0;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Display the chart -->
    <h2>Cost Per Business Unit</h2>
    <div id="chart_div" style="width: 800px; height: 400px;"></div>
    
</body>
</html>
