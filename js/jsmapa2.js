// Inicializar el mapa
var map = L.map('map').setView([-37.326, -59.139], 13); // Coordenadas de Tandil

// Añadir el mapa de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Función para buscar y centrar un lugar en el mapa
function searchPlace(query) {
    fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                var result = data[0];
                map.setView([result.lat, result.lon], 13); // Centra el mapa en las coordenadas encontradas
                L.marker([result.lat, result.lon]).addTo(map).bindPopup(result.display_name).openPopup(); // Añade un marcador en el lugar encontrado
            } else {
                alert('Lugar no encontrado');
            }
        })
        .catch(error => {
            console.error('Error al buscar el lugar:', error);
        });
}

// Agregar un cuadro de búsqueda global
var searchBox = document.createElement('input');
searchBox.setAttribute('type', 'text');
searchBox.setAttribute('placeholder', 'Buscar un lugar...');
searchBox.setAttribute('id', 'search-box');
searchBox.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        searchPlace(event.target.value);
    }
});
document.body.appendChild(searchBox);

// Agregar un botón para mostrar la ubicación del usuario
var locationButton = document.createElement('button');
locationButton.innerHTML = '<i class="fas fa-map-marker-alt"></i>';
locationButton.setAttribute('id', 'localizacion');
locationButton.style.position = 'absolute';
locationButton.style.top = '90px';
locationButton.style.right = '10px';
locationButton.style.zIndex = '1000';
locationButton.style.padding = '10px';
locationButton.style.border = '2px solid #ccc';
locationButton.style.borderRadius = '5px';
locationButton.style.fontSize = '16px';
locationButton.style.cursor = 'pointer';
locationButton.style.backgroundColor = 'white';
document.body.appendChild(locationButton);


// Agregar un botón para buscar con ícono de lupa
var searchButton = document.createElement('button');
searchButton.innerHTML = '<i class="fas fa-search"></i>'; // Ícono de lupa de FontAwesome
searchButton.setAttribute('id', 'search-button');
searchButton.style.position = 'absolute';
searchButton.style.top = '90px'; // Ajusta la posición vertical
searchButton.style.right = '50px'; // Ajusta la posición horizontal
searchButton.style.zIndex = '1000'; // Asegura que esté por encima del mapa
searchButton.style.padding = '10px';
searchButton.style.border = '2px solid #ccc';
searchButton.style.borderRadius = '5px';
searchButton.style.fontSize = '16px';
searchButton.style.cursor = 'pointer';
searchButton.style.backgroundColor = 'white';
searchButton.addEventListener('click', function() {
    var query = document.getElementById('search-box').value;
    searchPlace(query);
});
document.body.appendChild(searchButton);

// Función para activar/desactivar la ubicación del usuario
var isLocationEnabled = false;
var locationControl;

locationButton.addEventListener('click', function() {
    if (isLocationEnabled) {
        map.stopLocate();
        isLocationEnabled = false;
        locationButton.style.backgroundColor = 'white'; // Cambia el color de fondo a blanco
        locationButton.style.color = 'black'; // Cambia el color del texto a negro
        locationButton.innerHTML = '<i class="fas fa-map-marker-alt"></i>'; // Cambia al ícono original
        if (marker) {
            map.removeLayer(marker); // Remover el marcador cuando se desactiva la geolocalización
        }
    } else {
        map.locate({setView: true, maxZoom: 16});
        isLocationEnabled = true;
        locationButton.style.backgroundColor = '#3cff00'; // Cambia el color de fondo a verde
        locationButton.style.color = 'white'; // Cambia el color del texto a blanco
        locationButton.innerHTML = '<i class="fas fa-map-marker-alt"></i>'; // Cambia al ícono de desactivación
    }
});
var marker; // Variable para almacenar el marcador de la ubicación del usuario

// Escuchar el evento de ubicación del usuario
map.on('locationfound', function(e) {
    marker = L.marker(e.latlng).addTo(map);
    marker.bindPopup("Estás aquí").openPopup();
});

// Manejar errores de geolocalización
map.on('locationerror', function(e) {
    alert("No se pudo encontrar su ubicación. Por favor, permita el acceso a su ubicación o inténtelo de nuevo más tarde.");
});
