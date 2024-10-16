<script>
    document.addEventListener("DOMContentLoaded", function() {
        var map = L.map('map').setView([51.505, -0.09], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var scenarioDropdown = document.getElementById('scenarioDropdown');
        var markers = [];

        // Fetch CrisisScenarios from the server
        fetch('getCrisisScenarios.php')
            .then(response => response.json())
            .then(data => {
                // Populate dropdown with CrisisScenario names
                data.forEach(scenario => {
                    var option = document.createElement('option');
                    option.value = scenario.ID_ScenarioC;
                    option.textContent = scenario.CrisisName;
                    scenarioDropdown.appendChild(option);
                });

                // Add event listener to dropdown
                scenarioDropdown.addEventListener('change', updateMap);

                // Initial map update
                updateMap();
            })
            .catch(error => console.error('Error fetching CrisisScenarios:', error));

        function updateMap() {
            var selectedScenarioId = scenarioDropdown.value;
            console.log("Selected Scenario ID:", selectedScenarioId); // Debugging line

            // Clear existing markers
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            if (!selectedScenarioId) return;

            // Fetch data for the selected CrisisScenario from the server
            fetch(`mapPHP.php?scenario_id=${selectedScenarioId}`)
                .then(response => response.json())
                .then(data => {
                    // Add markers for each item in the response data
                    data.forEach(item => {
                        var lat = parseFloat(item.LatitudeC) || parseFloat(item.LatitudeA) || parseFloat(item.LatitudeR);
                        var lng = parseFloat(item.LongitudeC) || parseFloat(item.LongitudeA) || parseFloat(item.LongitudeR);
                        var name = item.NameComponent || item.ActorName || item.TypeRisk;

                        if (!isNaN(lat) && !isNaN(lng)) {
                            var marker = L.marker([lat, lng]).addTo(map);
                            marker.bindPopup(name);
                            markers.push(marker);
                        } else {
                            console.error('Invalid coordinates:', item);
                        }
                    });
                })
                .catch(error => console.error('Error fetching map data:', error));
        }
    });
</script>
