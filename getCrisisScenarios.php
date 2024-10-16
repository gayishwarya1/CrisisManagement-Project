<?php
header('Content-Type: application/json');

// Include database connection
include 'config.php';

// Fetch CrisisScenarios from the database
$query = "SELECT * FROM CrisisScenario";
$result = $mysqli->query($query);

if ($result) {
    $crisisScenarios = [];
    while ($row = $result->fetch_assoc()) {
        $crisisScenarios[] = $row;
    }
    echo json_encode($crisisScenarios);
} else {
    echo json_encode(['error' => 'Failed to fetch CrisisScenarios']);
}

$mysqli->close();
?>
