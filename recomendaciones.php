<?php
header('Content-Type: application/json');  // Asegúrate de que el contenido devuelto es JSON

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tansdtour";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Obtener el ID del usuario (asumiendo que se envía en la solicitud)
$usuario_id = isset($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : null;
$latitud_usuario = isset($_POST['latitud']) ? (float)$_POST['latitud'] : null;
$longitud_usuario = isset($_POST['longitud']) ? (float)$_POST['longitud'] : null;

// Verificar que todos los parámetros necesarios están presentes
if ($usuario_id === null || $latitud_usuario === null || $longitud_usuario === null) {
    echo json_encode(["error" => "Missing parameters"]);
    exit();
}

// Obtener la dificultad del usuario desde la tabla itinerario
$query_dificultad_usuario = "SELECT dificultad FROM itinerario WHERE usuario_id = ?";
$stmt_dificultad = $conn->prepare($query_dificultad_usuario);

if (!$stmt_dificultad) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit();
}

$stmt_dificultad->bind_param('i', $usuario_id);
$stmt_dificultad->execute();
$result_dificultad = $stmt_dificultad->get_result();

// Verificar si el usuario existe y obtener la dificultad
if ($result_dificultad->num_rows === 0) {
    echo json_encode(["error" => "User not found"]);
    exit();
}

$row_dificultad = $result_dificultad->fetch_assoc();
$dificultad_usuario = (int)$row_dificultad['dificultad'];

// Construir la consulta SQL basada en la dificultad del usuario
if ($dificultad_usuario === 0) {
    echo "soy 0";
    // Mostrar todas las ubicaciones (dificultad 0 y 1)
    $query_actividades = "SELECT *, (
        6371 * acos(
            cos(radians(?)) * cos(radians(lat)) *
            cos(radians(lon) - radians(?)) +
            sin(radians(?)) * sin(radians(lat))
        )
    ) AS distance
    FROM actividad
    WHERE dificultad IN (0,1)";
} else {
    echo "soy 1";
    // Mostrar solo ubicaciones con dificultad 0
    $query_actividades = "SELECT *, (
        6371 * acos(
            cos(radians(?)) * cos(radians(lat)) *
            cos(radians(lon) - radians(?)) +
            sin(radians(?)) * sin(radians(lat))
        )
    ) AS distance
    FROM actividad
    WHERE dificultad = 0";
}

// Preparar la consulta de actividades
$stmt_actividades = $conn->prepare($query_actividades);

if (!$stmt_actividades) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit();
}

// Bind de parámetros
$stmt_actividades->bind_param('ddd', $latitud_usuario, $longitud_usuario, $latitud_usuario);

// Ejecutar la consulta de actividades
$stmt_actividades->execute();

// Obtener los resultados
$result_actividades = $stmt_actividades->get_result();

// Almacenar resultados en un array
$actividades = [];
while ($row = $result_actividades->fetch_assoc()) {
    $actividades[] = $row;
}

// Enviar resultados como JSON
echo json_encode($actividades);

// Cerrar conexiones
$stmt_dificultad->close();
$stmt_actividades->close();
$conn->close();
?>
  sELECT *, ( 6371 * acos( cos(radians(-37.35491360)) * cos(radians(lat)) * cos(radians(lon) - radians(-59.17268680)) + sin(radians(-37.35491360)) * sin(radians(lat)) ) ) AS distance FROM actividad WHERE dificultad IN (0,1) ORDER by distance