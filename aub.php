<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Lugares Turísticos</title>
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Importar Lugares Turísticos de Tandil</h1>
    <button id="importButton">Importar</button>
    <p id="status"></p>
    <ul id="placesList"></ul>

    <script>
        document.getElementById('importButton').addEventListener('click', function() {
            const statusElement = document.getElementById('status');
            const placesList = document.getElementById('placesList');
            statusElement.textContent = 'Importando datos...';
            placesList.innerHTML = '';  // Limpiar la lista antes de importar

            // URL de la API de Overpass
            const url = 'https://overpass-api.de/api/interpreter?data=[out:json];area[name="Tandil"]->.searchArea;node[tourism=attraction](area.searchArea);out;';

            // Realizar la solicitud a la API
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const nodes = data.elements;
                    const places = nodes.map(node => ({
                        nombre: node.tags.name || 'Desconocido',
                        // Formato de las coordenadas como lon lat
                        coordenadas: `${node.lon} ${node.lat}`
                    }));

                    // Enviar los datos al servidor
                    return fetch('server.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(places)
                    });
                })
                .then(response => response.text())
                .then(result => {
                    statusElement.textContent = 'Datos importados correctamente!';
                    console.log(result);
                })
                .catch(error => {
                    statusElement.textContent = 'Error al importar los datos.';
                    console.error('Error:', error);
                });
        });
    </script>
</body>
</html>
