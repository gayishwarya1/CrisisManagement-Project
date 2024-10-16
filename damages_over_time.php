<?php
include 'config.php';

$query = "
SELECT C.CrisisName, O.DateOccuringRC, R.SeverityRD
FROM Occuring O
JOIN CrisisScenario C ON O.ID_ScenarioC = C.ID_ScenarioC
JOIN RisqDammages R ON O.Id_RD = R.Id_RD
ORDER BY O.DateOccuringRC
";

$result = $mysqli->query($query);
$data = [];

while($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Damages Increase Over Time</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>
<body>
<canvas id="damageChart" width="800" height="400"></canvas>
<script>
var ctx = document.getElementById('damageChart').getContext('2d');
var data = <?php echo json_encode($data); ?>;

var labels = [];
var datasets = {};

data.forEach(function(item) {
    var date = item.DateOccuringRC;
    if (!labels.includes(date)) {
        labels.push(date);
    }
    var crisis = item.CrisisName;
    if (!datasets[crisis]) {
        datasets[crisis] = [];
    }
    datasets[crisis].push(item.SeverityRD);
});

var chartData = {
    labels: labels,
    datasets: []
};

for (var crisis in datasets) {
    chartData.datasets.push({
        label: crisis,
        data: datasets[crisis],
        borderColor: 'rgba(' + (Math.random() * 255) + ', ' + (Math.random() * 255) + ', ' + (Math.random() * 255) + ', 1)',
        borderWidth: 1,
        fill: false
    });
}

var myChart = new Chart(ctx, {
    type: 'line',
    data: chartData,
    options: {
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'month'
                }
            }
        }
    }
});
</script>
</body>
</html>
