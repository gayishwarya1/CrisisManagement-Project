<?php
include 'header.php';
include 'config.php';

// Define number of scenarios per page
$scenariosPerPage = 10;

// Get the current page number from the URL, defaulting to 1 if not present
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $scenariosPerPage;

// Fetch the total number of scenarios
$totalResult = $mysqli->query("SELECT COUNT(*) AS total FROM CrisisScenario WHERE ID_ScenarioC <= 'c10'");
$totalRow = $totalResult->fetch_assoc();
$totalScenarios = $totalRow['total'];

// Fetch the scenarios for the current page
$query = "SELECT * FROM CrisisScenario WHERE ID_ScenarioC <= 'c10' LIMIT $scenariosPerPage OFFSET $offset";
$result = $mysqli->query($query);

// Check if the query was successful
if (!$result) {
    die('Query Error (' . $mysqli->errno . ') ' . $mysqli->error);
}

// Debug: Output JSON data
$scenarios = [];
while ($scenario = $result->fetch_assoc()) {
    $scenarios[] = $scenario;
}
echo '<pre>' . json_encode($scenarios, JSON_PRETTY_PRINT) . '</pre>';
?>