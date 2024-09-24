const map = L.map('map').setView([0, 0], 2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

const taxiIcon = L.icon({
    iconUrl: 'taxi.png', // Modificamos la ruta del icono para ir una carpeta hacia arriba
    iconSize: [50, 50]
});

let taxiMarker = null;
let currentMarker = null;
let currentRoute = null;

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            map.setView([lat, lng], 13);
            taxiMarker = L.marker([lat, lng], { icon: taxiIcon })
                .addTo(map)
                .bindPopup("Estás aquí")
                .openPopup();
        },
        (error) => {
            console.error("Error al obtener la ubicación:", error);
        }
    );
}

const selectedPlace = JSON.parse(localStorage.getItem('selectedPlace'));

if (selectedPlace) {
    const { lat, lng, name } = selectedPlace;
    
    if (currentMarker) {
        map.removeLayer(currentMarker);
    }
    
    currentMarker = L.marker([lat, lng])
        .addTo(map)
        .bindPopup(`Ubicación seleccionada: ${name}`)
        .openPopup();
    
    map.setView([lat, lng], 13);
} else {
    console.error("No hay lugar seleccionado en localStorage.");
}

function markRoute() {
    if (taxiMarker) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const startLat = position.coords.latitude;
                const startLng = position.coords.longitude;

                if (currentRoute) {
                    map.removeLayer(currentRoute);
                }

                const selectedPlace = JSON.parse(localStorage.getItem('selectedPlace'));
                if (selectedPlace) {
                    const routingUrl = `https://router.project-osrm.org/route/v1/driving/${startLng},${startLat};${selectedPlace.lng},${selectedPlace.lat}?overview=full&geometries=geojson`;

                    fetch(routingUrl)
                        .then(response => response.json())
                        .then(data => {
                            if (data.routes && data.routes.length > 0) {
                                const route = data.routes[0];
                                const coordinates = route.geometry.coordinates;

                                currentRoute = L.geoJSON(route.geometry).addTo(map);

                                coordinates.forEach(function (coord, index) {
                                    setTimeout(function () {
                                        taxiMarker.setLatLng([coord[1], coord[0]]);
                                    }, 100 * index);
                                });
                            }
                        })
                        .catch(error => console.error("Error al obtener la ruta:", error));
                }
            },
            (error) => {
                console.error("Error al obtener la ubicación:", error);
            }
        );
    }
}




document.getElementById("scrollBtnup").addEventListener("click", function() {
    if (window.scrollY > 0) { // Si la página está desplazada hacia abajo
        scrollToTop(); // Llama a la función para desplazar hacia arriba
    } else {
        scrollToBottom(); // De lo contrario, desplaza hacia abajo
    }
});

document.getElementById("scrollBtndown").addEventListener("click", function() {
    if (window.scrollY > 0) { // Si la página está desplazada hacia abajo
        scrollToTop(); // Llama a la función para desplazar hacia arriba
    } else {
        scrollToBottom(); // De lo contrario, desplaza hacia abajo
    }
});

function scrollToBottom() {
    window.scrollTo(0, document.body.scrollHeight);
}

function scrollToTop() {
    window.scrollTo(0, 0);
}








