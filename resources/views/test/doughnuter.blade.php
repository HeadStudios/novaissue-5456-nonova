<html>
<head>
    <title>Doughnut JSChart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
</head>
<body>
    <canvas id="doughnutChart" width="400" height="400"></canvas>
    <script>
        const ctx = document.getElementById('doughnutChart').getContext('2d');
        const doughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [50, 50],
                    backgroundColor: ['#00c853', '#e0e0e0'],
                    label: 'Filled Orders'
                }]
            },
            options: {
                cutoutPercentage: 75,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        fontColor: 'black'
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var index = tooltipItem.index;
                            if (index === 0) {
                                return 'Filled Orders: ' + dataset.data[index] + '%';
                            } else {
                                return 'Empty Orders: ' + dataset.data[index] + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>