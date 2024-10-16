<div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
    var map = L.map('map').setView([51.505, -0.09], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    fetch('mapPHP.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        data.forEach(item => {
            var lat = parseFloat(item.LatitudeRD);
            var lng = parseFloat(item.LongitudeRD);

            if (!isNaN(lat) && !isNaN(lng)) {
                var marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup(`<b>Scenario: ${item.CrisisName} (${item.CrisisType})</b><br>
                                  City: ${item.CityNameC}, ${item.CountryNameC}<br>
                                  Start: ${item.StartingTimeC} - End: ${item.EndingTimeC}<br>
                                  Risk: ${item.TypeRisk} (${item.NameRD})<br>
                                  Component: ${item.NameComponent} (${item.TypeComponent})`);
            } else {
                console.error(`Invalid coordinates for item: ${JSON.stringify(item)}`);
            }
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
</script>