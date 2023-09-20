<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Page</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
       
        /* Add a light blue background to the entire page */
        body {
            
            
        top: 0;
        height: 100vh;
     
        display:flex;
        /* You can adjust the color code as needed */
        }

        /* Style the container for the links on the left */
        .sidebar {
            background-color: #f0f8ff; 
            float: left;
            width: 30%;
         padding-bottom:3%;
            font-size:40px;
            margin-left:7%;
            height:70%;
            margin-top:5%;
            padding-left:5%;
            border-right: 5px solid white;
            box-shadow: 5px 5px  5px 5px;
        }

        /* Style the links in the sidebar */
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
        }

        .sidebar a:hover {
            color: #007bff; /* Change link color on hover */
        }

        /* Style the container for the chart on the right */
        .chart-container {
            float: left;
            width: 50%;
            height:70%;
            margin-top:5%;
            background-color: #f0f8ff; 
            padding-bottom:3%;
            box-shadow:5px 5px  5px 5px;
            
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <!-- Create links on the left -->
        <h3>OFI</h3>
        <ul>
            <li><a href="#" onclick="displayChart('bar')">Bar Chart</a></li>
            <li><a href="#" onclick="displayChart('line')">Line Chart</a></li>
            <li><a href="#" onclick="displayChart('pie')">Pie Chart</a></li>
        </ul>
    </div>
    <div class="chart-container">
        <!-- Create a canvas for the chart -->
        <canvas id="myChart" width="500" height="400" style="margin-left:6%"></canvas>
    </div>
  
    <script>
        // Declare a variable to hold the currently displayed chart
        let currentChart;

        // Function to display a chart based on the selected chart type
        function displayChart(chartType) {
            // Remove the existing chart if it exists
            if (currentChart) {
                currentChart.destroy();
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var chartConfig = {
                type: chartType,
                data: {
                    labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
                    datasets: [{
                        label: 'Sample Data',
                        data: [12, 19, 3, 5, 2], // Replace with your chart data
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            // Create and display the new chart
            currentChart = new Chart(ctx, chartConfig);
        }
    </script>
</body>
</html>
