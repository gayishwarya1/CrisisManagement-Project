<?php
include 'config.php';

// Get the current year
$current_year = date('Y');

// Query to fetch crisis scenarios occurring in the current year
$query = "SELECT * FROM CrisisScenario WHERE YEAR(StartingTimeC) = '$current_year'";
$result = $mysqli->query($query);

$scenarios = [];

if ($result->num_rows > 0) {
    // Loop through each scenario and add to the array
    while ($row = $result->fetch_assoc()) {
        $scenarios[] = $row;
    }
}

// Close database connection
$mysqli->close();

// Return the scenarios as a JSON object
header('Content-Type: application/json');
echo json_encode($scenarios);
?>
