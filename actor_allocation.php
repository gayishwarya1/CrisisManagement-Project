	

<?php
include 'config.php';

// Fetch data by joining CrisisScenario, RealActivity, and do tables
$sql = "
    SELECT cs.AffectedPlaces, COUNT(DISTINCT d.Actor_ID) as actor_count,
           YEAR(cs.StartingTimeC) as year
    FROM CrisisScenario cs
    JOIN include i ON cs.ID_ScenarioC = i.ID_ScenarioC
    JOIN RealActivity ra ON i.IDRealActivity = ra.IDRealActivity
    JOIN do d ON ra.IDRealActivity = d.IDRealActivity
    GROUP BY cs.AffectedPlaces, year";

$result = $mysqli->query($sql);

$affected_places = [];
$actor_counts = [];
$current_crisis_flags = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $affected_places[] = $row['AffectedPlaces'];
        $actor_counts[] = $row['actor_count'];
        $current_crisis_flags[] = ($row['year'] == 2024) ? 'red' : 'blue';
    }
} else {
    echo "0 results from the joined tables";
}

$mysqli->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Optimal Resource Allocation</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Resource Allocation</h2>
<canvas id="allocationChart" width="400" height="180"></canvas>

<script>
    var ctx = document.getElementById('allocationChart').getContext('2d');
    var allocationChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($affected_places); ?>, // X-axis labels
            datasets: [{
                label: 'Number of Actors',
                data: <?php echo json_encode($actor_counts); ?>, // Y-axis data
                backgroundColor: <?php echo json_encode($current_crisis_flags); ?>, // Bar colors
                borderColor: 'rgba(0, 0, 0, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
