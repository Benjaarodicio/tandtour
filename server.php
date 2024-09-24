<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'tandtour';

// Conectar a la base de datos
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // Preparar la consulta SQL para insertar datos en la tabla `actividades`
    $stmt = $conn->prepare('INSERT INTO actividades (nombre, lon, lat) VALUES (?, ?, ?)');
    
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    foreach ($data as $place) {
        $nombre = $place['nombre'];
        list($lon, $lat) = explode(' ', $place['coordenadas']);
        $stmt->bind_param('sdd', $nombre, $lon, $lat);
        if (!$stmt->execute()) {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        } else {
            echo "Datos de $nombre insertados correctamente.<br>";
        }
    }

    $stmt->close();
    echo "Datos importados correctamente!";
} else {
    echo "No se recibieron datos.";
}

$conn->close();
?>
