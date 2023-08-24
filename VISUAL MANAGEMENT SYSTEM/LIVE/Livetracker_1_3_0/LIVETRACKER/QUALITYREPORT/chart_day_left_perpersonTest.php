<!DOCTYPE html>
<html>
<head>
    <title>Urgency Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <style>
        body
        {
        height:100vh;
        }
        </style>
<body>

    <canvas id="urgencyChart" width="50%" height="50%"></canvas>
<body>
    <script>
        // Data from the table
        var data = {
            labels: ["Jamie Kent", "Colm Whelan", "Lorcan Kent", "Sean O Brien (Q)", "Sean O'Brien", "Brian Murphy", "Eamonn Donovan", "Jim Whelan", "Dean Maloney", "Tony Byrne"],
            datasets: [
                {
                    label: "Least Urgent Action",
                    data: [16, 2, 2, 2, -19, 16, 16, -19, 16, 2],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: "Most Urgent Action",
                    data: [-3, -17, -10, -17, -19, -10, -19, -19, 16, 2],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        };

        // Chart configuration
        var config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Create the chart
        var ctx = document.getElementById('urgencyChart').getContext('2d');
        var myChart = new Chart(ctx, config);
    </script>
</body>
</html>
