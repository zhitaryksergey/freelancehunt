<script src='https://www.chartjs.org/dist/2.9.3/Chart.min.js'></script>
<script src='<?= IRB_HOST ?>skins/js/utils.js'></script>
<div class="myChart">
    <canvas id="myChart" width="800" height="800"></canvas>
</div>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['до 500 грн', '500-1000 грн', '1000-5000 грн', 'более 5000 грн.'],
            datasets: [{
                label: '# количество проектов',
                data: [<?= implode(',', $tpl_chart) ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
