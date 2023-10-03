
function displayChart_8() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    // Get the chart canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($Labels_rd); ?>,
            datasets: [{
                label: 'Open Occurrences of OFI per Area Raised',
                data: <?php echo json_encode($Values_rd); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                datalabels: { // Configure the datalabels plugin
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value; // Display the data value on top of the bar
                    }
                }
            }
        }
    });

    // Show the chart canvas
    document.getElementById('myChart').style.display = 'block';
}
