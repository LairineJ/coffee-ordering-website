// script.js
document.addEventListener("DOMContentLoaded", function () {
    // Remove the line that shows the modal on page load
    //$('#locationModal').modal('show');

    // Function to initialize the Leaflet map when the modal is shown
    $('#locationModalContent, #checkoutModal').on('shown.bs.modal', function () {
        // Set the coordinates for the shop location (98 Captain Cruz, Parada, Valenzuela)
        var shopCoordinates = [14.68709, 120.98409];

        // Initialize the Leaflet map inside the modal body for #locationModalContent
        var locationMap = L.map('locationMapContainer', {
            minZoom: 6 // Set minimum zoom level
        }).setView(shopCoordinates, 15);

        // Add a tile layer from OpenStreetMap for #locationModalContent
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(locationMap);
        
        // Initialize the Leaflet map inside the modal body
        var map = L.map('mapContainer', {
            minZoom: 6 // Set minimum zoom level
        }).setView(shopCoordinates, 15);

        // Add a tile layer from OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Variable to store the marker on the map for the shop location
        var shopMarker = L.marker(shopCoordinates).addTo(map).bindPopup('Shop Location').openPopup();
        var shopMarker = L.marker(shopCoordinates).addTo(locationMap).bindPopup('Shop Location').openPopup();

        // Variable to store the marker on the map for the user's inputted address
        var userMarker;

        // Function to search for a location using Nominatim API and display it on the map
        window.searchLocation = function () {
            var activeModal = $('.modal.show');
            var locationInput, leafletMap;

            // Remove the previous user marker and polyline if they exist
            if (userMarker) {
                map.removeLayer(userMarker);
                locationMap.removeLayer(userMarker);
            }

            if (activeModal.is('#locationModalContent')) {
                locationInput = document.getElementById('locationInput').value;
                leafletMap = locationMap;
            }

            if (activeModal.is('#checkoutModal')) {
                locationInput = document.getElementById('checkoutInput').value;
                leafletMap = map;
            }

            if (activeModal.length > 0) {
                // Use the Nominatim API to search for the user's inputted location
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(locationInput)}`)
                    .then(response => response.json())
                    .then(data => {
                        handleLocationFetchResult(data, locationInput, leafletMap);
                        updateShippingFee();
                        enableCheckoutButton();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error fetching location data');
                    });
            }
        };
        leafletMap = null;  // or not initialized
        // Function to handle the result of the fetch request
        function handleLocationFetchResult(data, input, leafletMap) {
            if (data.length > 0) {
                // Get the coordinates of the first result
                var userLat = parseFloat(data[0].lat);
                var userLon = parseFloat(data[0].lon);

                // Add a marker for the user's inputted address
                userMarker = L.marker([userLat, userLon]).addTo(leafletMap).bindPopup(input).openPopup();

                // Draw a polyline to represent the route from the shop to the user's inputted address
                var routeCoordinates = [shopCoordinates, [userLat, userLon]];
                var polyline = L.polyline(routeCoordinates, { color: 'red' }).addTo(leafletMap);

                // Center the map on the user's inputted address and adjust zoom level
                leafletMap.setView([userLat, userLon], 15);

                // Calculate and display the shipping fee based on the distance
                var distance = leafletMap.distance(shopCoordinates, [userLat, userLon]) / 1000;
                var shippingFee = calculateShippingFee(distance);

                sessionStorage.setItem('shippingFee', shippingFee.toFixed(2));
                
                console.log('Shipping Fee:', shippingFee.toFixed(2)); // Log shipping fee to the console


                // Set a cookie with the JavaScript variable
                document.cookie = "shippingFee=" + shippingFee;

                document.getElementById('confirmButton').disabled = false;
            } else {
                alert('Location not found');
            }
        }

        // Function to calculate the shipping fee based on distance
        function calculateShippingFee(distance) {
            var feePerKm = 20; // PHP per kilometer
            return distance * feePerKm;
        }
    });
});


$('#locationModal').on('shown.bs.modal', function () {
            // Check if the locationModalContent is the active modal
        if ($('#locationModalContent').hasClass('show')) {
            console.log('locationModalContent is shown');
        }

            // Set the value of locationInput
        var prevLoc = "<?php echo $prevLoc; ?>";
        $('#locationInput').val(prevLoc);
    });


