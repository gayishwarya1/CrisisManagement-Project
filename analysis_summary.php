<?php
include 'config.php';

// Query to get total counts for components, risks, activities, and crisis scenarios
$queries = [
    "components" => "SELECT COUNT(*) as count FROM Component",
    "risks" => "SELECT COUNT(*) as count FROM Risk",
    "activities" => "SELECT COUNT(*) as count FROM Activity",
    "crisis_scenarios" => "SELECT COUNT(*) as count FROM CrisisScenario"
];

foreach ($queries as $key => $query) {
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    echo "Total " . ucfirst($key) . ": " . $row['count'] . "\n";
}

$mysqli->close();
?>
