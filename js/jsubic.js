document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('map').setView([userLat, userLon], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        maxZoom: 20,
    }).addTo(map);

    const userMarker = L.marker([userLat, userLon]).addTo(map)
        .bindPopup('Ubicación del Usuario')
        .openPopup();

    const markers = {};
    const locations = {};
    document.querySelectorAll('.ubicacion').forEach(div => {
        const id = div.id;
        const lat = parseFloat(div.dataset.lat);
        const lon = parseFloat(div.dataset.lon);
        locations[id] = { lat, lon };
    });

    let routeControl = null;
    let selectedLocation = null;

    function toggleMarker(id) {
        if (selectedLocation) {
            map.removeLayer(markers[selectedLocation]);
            document.getElementById(selectedLocation).classList.remove('selected');
            if (routeControl) {
                map.removeControl(routeControl);
                routeControl = null;
                document.getElementById('clear-route').style.display = 'none';
            }
        }

        if (selectedLocation === id) {
            selectedLocation = null;
            return;
        }

        selectedLocation = id;
        const latLng = locations[id];
        markers[id] = L.marker([latLng.lat, latLng.lon]).addTo(map);
        document.getElementById(id).classList.add('selected');
    }

    document.querySelectorAll('.ubicacion').forEach(div => {
        div.addEventListener('click', function() {
            const id = this.id;
            toggleMarker(id);
            if (!selectedLocation) {
                userMarker.addTo(map);
            }
        });
    });

    document.querySelectorAll('.directions-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const lat = parseFloat(this.dataset.lat);
            const lon = parseFloat(this.dataset.lon);

            if (routeControl) {
                map.removeControl(routeControl);
                routeControl = null;
                document.getElementById('clear-route').style.display = 'none';
            }

            routeControl = L.Routing.control({
                waypoints: [
                    L.latLng(userLat, userLon),
                    L.latLng(lat, lon)
                ],
                createMarker: function() { return null; },
                routeWhileDragging: true,
                geocoder: L.Control.Geocoder.nominatim()
            }).addTo(map);

            document.getElementById('clear-route').style.display = 'block';

            if (selectedLocation && selectedLocation !== this.parentElement.id) {
                map.removeLayer(markers[selectedLocation]);
                document.getElementById(selectedLocation).classList.remove('selected');
            }
        });
    });

    // Asegúrate de que el botón exista
    const clearRouteButton = document.getElementById('clear-route');
    if (clearRouteButton) {
        clearRouteButton.addEventListener('click', function() {
            if (routeControl) {
                map.removeControl(routeControl);
                routeControl = null;
                this.style.display = 'none';
            }
        });
    }

    map.on('moveend', () => {
        const bounds = L.latLngBounds([userLat, userLon]);
        map.fitBounds(bounds, { padding: [50, 50] });
    });
});
