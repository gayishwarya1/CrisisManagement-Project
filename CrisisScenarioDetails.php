<?php
include 'header.php';
include 'config.php';

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $scenario_id = $mysqli->real_escape_string($_GET['id']);

    // Fetch scenario details from the database based on the provided ID
    $query = "SELECT * FROM CrisisScenario WHERE ID_ScenarioC = '$scenario_id'";
    $result = $mysqli->query($query);

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Fetch scenario details
        $scenario = $result->fetch_assoc();

        // Fetch actor details related to the scenario
        $actor_query = "
            SELECT DISTINCT Actor.ActorName, Actor.LatitudeA, Actor.LongitudeA
            FROM Actor
            JOIN perform ON Actor.Actor_ID = perform.Actor_ID
            JOIN Activity ON perform.IdActivity = Activity.IdActivity
            JOIN RealActivity ON Activity.IdActivity = RealActivity.IdActivity
            JOIN include ON RealActivity.IDRealActivity = include.IDRealActivity
            WHERE include.ID_ScenarioC = '$scenario_id'
        ";
        $actor_result = $mysqli->query($actor_query);

        // Fetch component details related to the scenario
        $component_query = "
            SELECT DISTINCT Component.NameComponent, Component.LatitudeC, Component.LongitudeC 
            FROM Component
            JOIN Impacting ON Component.IdComponent = Impacting.IdComponent
            JOIN Occuring ON Impacting.Id_RD = Occuring.Id_RD
            WHERE Occuring.ID_ScenarioC = '$scenario_id'
        ";
        $component_result = $mysqli->query($component_query);

        // Fetch risk damages details related to the scenario
        $risk_query = "
            SELECT DISTINCT RisqDammages.NameRD, RisqDammages.ImpactDescription, RisqDammages.LatitudeRD, RisqDammages.LongitudeRD 
            FROM RisqDammages
            JOIN Occuring ON RisqDammages.Id_RD = Occuring.Id_RD
            WHERE Occuring.ID_ScenarioC = '$scenario_id'
        ";
        $risk_result = $mysqli->query($risk_query);

        // Fetch data into arrays for JavaScript
        $actors = [];
        while ($actor = $actor_result->fetch_assoc()) {
            $actors[] = $actor;
        }

        $components = [];
        while ($component = $component_result->fetch_assoc()) {
            $components[] = $component;
        }

        $risks = [];
        while ($risk = $risk_result->fetch_assoc()) {
            $risks[] = $risk;
        }
?>


<main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1><?= htmlspecialchars($scenario['CrisisName']) ?></h1>
                        
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="CrisisScenario.php">Crisis Scenario</a></li>
                    <li class="current"><?= htmlspecialchars($scenario['CrisisName']) ?></li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Blog Posts Section -->
    <section id="blog-posts" class="blog-posts section">
        <div class="container">
            <div class="row gy-4">
                <!-- Crisis Scenario Details Block -->
                <!-- Crisis Scenario Details Block -->
<div class="col-lg-3">
    <article>
        <div class="post-img">
            <img src="data:image/jpeg;base64,<?= base64_encode($scenario['ImageC']) ?>" alt="<?= htmlspecialchars($scenario['CrisisName']) ?>" class="img-fluid">
        </div>
        <p class="post-category"><?= htmlspecialchars($scenario['CrisisName']) ?></p>
        <h2 class="title">
            <?= htmlspecialchars($scenario['CrisisType']) ?> in <?= htmlspecialchars($scenario['CityNameC']) ?>, <?= htmlspecialchars($scenario['CountryNameC']) ?>
        </h2>
        <div class="d-flex align-items-center">
            <div class="post-meta">
                <p class="post-author"><?= htmlspecialchars($scenario['AreaC']) ?></p>
                <p class="post-date"> <strong>Starting Time:</strong>
                    <time datetime="<?= htmlspecialchars($scenario['StartingTimeC']) ?>"><?= date('M d, Y', strtotime($scenario['StartingTimeC'])) ?></time>
                </p>
            </div>
        </div>
        <p><strong>Affected Area:</strong> <?= htmlspecialchars($scenario['AffectedPlaces']) ?></p>
        <p><strong>Ending Time:</strong> 
            <?php 
            if (empty($scenario['EndingTimeC'])) {
                echo 'Ongoing';
            } else {
                echo date('M d, Y', strtotime($scenario['EndingTimeC']));
            }
            ?>
        </p>
    </article>
</div><!-- End Crisis Scenario Details Block -->


              
<!-- Actor Details Block -->
<div class="col-lg-3">
    <article>
        <p class="post-category" style="font-weight: bold; font-size: 1.2em;">Actors Involved</p>
        <?php
        // Reset the pointer of $actor_result to the beginning
        $actor_result->data_seek(0);
        while ($actor = $actor_result->fetch_assoc()): ?>
            <p><?= htmlspecialchars($actor['ActorName']) ?></p>
        <?php endwhile; ?>
    </article>
</div><!-- End Actor Details Block -->


                <!-- Component Details Block -->
                <div class="col-lg-3">
                    <article>
                        <p class="post-category" style="font-weight: bold; font-size: 1.2em;">Components Affected</p>
                        <?php foreach ($components as $component): ?>
                            <p><?= htmlspecialchars($component['NameComponent']) ?></p>
                        <?php endforeach; ?>
                    </article>
                </div><!-- End Component Details Block -->

                <!-- Risk Damages Details Block -->
                <div class="col-lg-3">
                    <article>
                        <p class="post-category" style="font-weight: bold; font-size: 1.2em;">Risk Damages</p>
                        <?php foreach ($risks as $risk): ?>
                            <p><?= htmlspecialchars($risk['ImpactDescription']) ?></p>
                        <?php endforeach; ?>
                    </article>
                </div><!-- End Risk Damages Details Block -->
            </div><!-- End row -->
            
        </div>
    </section><!-- /Blog Posts Section -->

    <!-- Map Section -->
 <section id="map-section" class="section">
        <div class="container">
            <div id="map" style="height: 500px;"></div>
        </div>
        
        <div class="text-center mt-4">
            <a href="javascript:history.back()" class="btn btn-primary">Back</a>
			 <a href="actor_allocation.php" class="btn btn-primary">Check Actor Allocation</a>
			 <a href="TimeRisk.jpg" class="btn btn-primary">Risk Damages Over Time</a>
        </div>
		
    </section><!-- /Map Section -->

</main>
<script>
    // Initialize map centered on Toulouse
    var map = L.map('map').setView([43.6045, 1.4442], 12); // Toulouse coordinates

    // Set up the OpenStreetMap layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // PHP arrays converted to JavaScript arrays
    var actors = <?php echo json_encode($actors); ?>;
    var components = <?php echo json_encode($components); ?>;

    // Add markers for actors
    var actorIcon = L.icon({
        iconUrl: 'actor.png', // Replace with your icon path for actors
        iconSize: [50, 50],
    });
    var actorMarkers = [];
    actors.forEach(function(actor) {
        var actorMarker = L.marker([actor['LatitudeA'], actor['LongitudeA']], {icon: actorIcon})
            .bindPopup('<strong>Actor:</strong> ' + actor['ActorName'])
            .addTo(map);
        actorMarkers.push(actorMarker);
    });

    // Add markers for components
    var componentIcon = L.icon({
        iconUrl: 'home-1.png', // Replace with your icon path for components
        iconSize: [50, 50],
    });
    var componentMarkers = [];
    components.forEach(function(component) {
        var componentMarker = L.marker([component['LatitudeC'], component['LongitudeC']], {icon: componentIcon})
            .bindPopup('<strong>Component:</strong> ' + component['NameComponent'])
            .addTo(map);
        componentMarkers.push(componentMarker);
    });

    // Fit map to show all markers (actors and components)
    var allMarkers = [];
    actorMarkers.forEach(function(marker) {
        allMarkers.push(marker.getLatLng());
    });
    componentMarkers.forEach(function(marker) {
        allMarkers.push(marker.getLatLng());
    });
    map.fitBounds(allMarkers);
</script>

<?php
    } else {
        // Scenario not found
        echo "<p>Crisis scenario not found.</p>";
    }
} else {
    // ID parameter not set in the URL
    echo "<p>Error: Scenario ID not provided.</p>";
}

include 'footer.php';
?>
