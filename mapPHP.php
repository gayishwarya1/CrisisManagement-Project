<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

// Include the database connection
include 'config.php';

// Check if a scenario ID is provided
if (isset($_GET['scenario_id'])) {
    $scenario_id = intval($_GET['scenario_id']);
    
    // Debugging line
    error_log("Received Scenario ID: " . $scenario_id);

    // Prepare the SQL query to fetch related data for the specified CrisisScenario
    $query = $conn->prepare("
        SELECT 
            Component.NameComponent, Component.LatitudeC, Component.LongitudeC,
            Actor.ActorName, Actor.LatitudeA, Actor.LongitudeA,
            Risk.TypeRisk, Risk.LatitudeR, Risk.LongitudeR
        FROM CrisisScenario
        LEFT JOIN Component ON CrisisScenario.ID_ScenarioC = Component.CrisisScenarioID
        LEFT JOIN Actor ON CrisisScenario.ID_ScenarioC = Actor.CrisisScenarioID
        LEFT JOIN Risk ON CrisisScenario.ID_ScenarioC = Risk.CrisisScenarioID
        WHERE CrisisScenario.ID_ScenarioC = ?
    ");
    $query->bind_param("i", $scenario_id);

    // Execute the query
    if ($query->execute()) {
        $result = $query->get_result();
        $data = [];

        // Fetch data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Send the JSON response
        echo json_encode($data);
    } else {
        // Query execution failed
        echo json_encode(['error' => 'Failed to execute query.']);
    }

    // Close the statement and connection
    $query->close();
    $conn->close();
} else {
    // No scenario ID provided
    echo json_encode(['error' => 'CrisisScenario ID not provided.']);
}
?>
