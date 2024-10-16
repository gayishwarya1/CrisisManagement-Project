<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Map</title>
    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Include Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Include your custom JavaScript file -->
    <script src="map.js"></script>
    <style>
        #map { height: 600px; }
    </style>
</head>
<body>
    <!-- Create a container for the map -->
    <div id="map"></div>

    <!-- Your custom JavaScript code will go here -->
    <script>
        // Initialize the map
        var map = L.map('map').setView([51.505, -0.09], 2); // Set the initial center and zoom level

        // Add a tile layer (e.g., OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Your custom JavaScript code for adding markers to the map will go here
        // Example: Add a marker at a specific location
        var marker = L.marker([51.5, -0.09]).addTo(map);
        marker.bindPopup("<b>Toulouse</b>").openPopup();
    </script>
</body>
</html>
