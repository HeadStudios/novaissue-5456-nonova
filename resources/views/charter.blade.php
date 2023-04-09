<html>
    <head>
        <title> Let's go</title>
    
<style>
    #beta {
        width: 50%;
        height: auto;
    }
    </style>
</head>
<body>
    {{ $name }} - {{ $status->renderChartCode() }}
<div id="beta">
  <canvas id="myChart" style="width:200px;height:200px;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'doughnut',
    data: {
    datasets: [{
        data: {{ json_encode($data) }}, // 50% completed
        backgroundColor: ['#00c853', '#e0e0e0']
    }]
},
    options: {
    cutoutPercentage: 75,
    width: 300,
    height: 300,
    legend: {
        display: true
    },
    tooltips: {
        enabled: false
    }
}
  });
</script>
</body>
</html>