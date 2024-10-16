<?php
include 'config.php';

header('Content-Type: application/json');

try {
    $currentDate = date('Y-m-d');
    $query = "
        SELECT 
            CS.CrisisName AS crisisName, 
            CS.StartingTimeC AS startDate, 
            A.NameA AS activityName, 
            Ac.Actor_ID AS actorId, 
            Ac.ActorName AS actorName
        FROM CrisisScenario CS
        JOIN include I ON CS.ID_ScenarioC = I.ID_ScenarioC
        JOIN RealActivity RA ON I.IDRealActivity = RA.IDRealActivity
        JOIN Activity A ON RA.IdActivity = A.IdActivity
        JOIN perform P ON A.IdActivity = P.IdActivity
        JOIN Actor Ac ON P.Actor_ID = Ac.Actor_ID
    ";

    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Database Query Failed: " . $mysqli->error);
    }

    $data = [
        'current' => [],
        'past' => []
    ];

    while ($row = $result->fetch_assoc()) {
        $crisisName = $row['crisisName'];
        $activityName = $row['activityName'];
        $actorId = $row['actorId'];
        $actorName = $row['actorName'];
        $startDate = $row['startDate'];

        $key = ($startDate >= $currentDate) ? 'current' : 'past';

        if (!isset($data[$key][$crisisName])) {
            $data[$key][$crisisName] = [];
        }
        if (!isset($data[$key][$crisisName][$activityName])) {
            $data[$key][$crisisName][$activityName] = [];
        }
        $data[$key][$crisisName][$activityName][] = [
            'actorId' => $actorId,
            'actorName' => $actorName
        ];
    }

    echo json_encode($data);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
