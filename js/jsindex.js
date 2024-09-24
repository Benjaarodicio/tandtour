function generateCatalog() {
    const days = parseInt(document.getElementById('days').value);

    if (isNaN(days) || days < 1) {
        alert("Por favor, introduce un número válido de días.");
        return;
    }

    const places = [
        { name: "Piedra Movediza", description: "lugar con buenas vistas.", lat: -37.30944, lng: -59.16962 },
        { name: "Cerro Centinela", description: "otro lugar con buenas vistas.", lat: -37.35492, lng: -59.17267 },
        { name: "dique", description: "lindo lugar para tomar mates y pasar el dia.", lat: -37.34287, lng: -59.13213 },
        { name: "museo de autos", description: "muy buenos autos antiguos.", lat: -37.32494, lng: -59.14477 },
    ];

    const selectedPlaces = places.slice(0, days);
    const placesContainer = document.getElementById('places');

    // Limpia el contenedor antes de agregar nuevos lugares
    placesContainer.innerHTML = "";

    selectedPlaces.forEach(place => {
        const placeElement = document.createElement("div");
        placeElement.className = "place";

        const placeHTML = `
            <h3>${place.name}</h3>
            <p>${place.description}</p>
            <button class="button" onclick="selectPlace('${place.name}', ${place.lat}, ${place.lng})">Ver en el mapa</button>
        `;

        placeElement.innerHTML = placeHTML;
        placesContainer.appendChild(placeElement);
    });
}

function selectPlace(name, lat, lng) {
    // Limpia cualquier ruta anterior guardada
    localStorage.removeItem('selectedRoute');

    // Guarda el nuevo lugar seleccionado
    localStorage.setItem('selectedPlace', JSON.stringify({ name, lat, lng }));

    // Redirige a la página del mapa
    window.location.href = 'mapa.html';
}
