<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_usuario = $_SESSION['user_id'];

// Obtener la dificultad y el tipo de actividad del usuario
$sql = "SELECT dificultades, tipoactividad FROM itinerario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

$dificultad_usuario = $user_data['dificultades'] ?? '0';
$tipoactividad_usuario = $user_data['tipoactividad'] ?? '4';

$dificultad_usuario = intval($dificultad_usuario);
$tipoactividad_usuario = intval($tipoactividad_usuario);

// Coordenadas del usuario (por defecto las de Tandil)
$lat_usuario = -37.3217;
$lon_usuario = -59.1332;

// Obtener el clima actual en Tandil usando la API de OpenWeatherMap
$apiKey = 'b1a519fdb6566e96051641bd9720b887';
$weatherUrl = "http://api.openweathermap.org/data/2.5/weather?lat=$lat_usuario&lon=$lon_usuario&appid=$apiKey&units=metric&lang=es";

$weatherData = file_get_contents($weatherUrl);
$weather = json_decode($weatherData, true);

// Verificar si el clima está lluvioso
$clima_recomendado = false;
if ($weather && isset($weather['weather'][0]['main'])) {
    $clima = $weather['weather'][0]['main'];
    if ($clima == 'Rain' || $clima == 'Drizzle' || $clima == 'Thunderstorm') {
        $clima_recomendado = true;
    }
}

// Consultar las actividades basadas en el clima, dificultad y tipo de actividad
if ($clima_recomendado) {
    // Si está lloviendo, recomendar actividades en lugares cerrados (tipoactividad = 3)
    $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad WHERE tipoactividad = 3";
} else {
    if ($dificultad_usuario === 0) {
        if ($tipoactividad_usuario === 4) {
            // Todas las actividades
            $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad";
        } else {
            // Solo actividades que coincidan con el tipo de actividad del usuario
            $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad WHERE tipoactividad = ?";
        }
    } elseif ($dificultad_usuario === 1) {
        if ($tipoactividad_usuario === 4) {
            // Todas las actividades con dificultad 0
            $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad WHERE dificultad = '0'";
        } else {
            // Actividades con dificultad 0 y el tipo de actividad seleccionado
            $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad WHERE dificultad = '0' AND tipoactividad = ?";
        }
    } else {
        if ($tipoactividad_usuario === 4) {
            // Todas las actividades con dificultad 1
            $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad WHERE dificultad = '1'";
        } else {
            // Actividades con dificultad 1 y el tipo de actividad seleccionado
            $sql = "SELECT id_actividad, nombre, lat, lon FROM actividad WHERE dificultad = '1' AND tipoactividad = ?";
        }
    }
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

if (!$clima_recomendado && $tipoactividad_usuario !== 4) {
    $stmt->bind_param('i', $tipoactividad_usuario);
}

$stmt->execute();
$result = $stmt->get_result();
$ubicaciones = [];

// Función para calcular la distancia
function calcular_distancia($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earth_radius * $c;
}

// Almacenar ubicaciones y distancias
while ($row = $result->fetch_assoc()) {
    $distancia = calcular_distancia($lat_usuario, $lon_usuario, $row['lat'], $row['lon']);
    $row['distancia'] = round($distancia, 2);
    $ubicaciones[] = $row;
}

// Ordenar ubicaciones por distancia
usort($ubicaciones, function($a, $b) use ($lat_usuario, $lon_usuario) {
    $dist_a = calcular_distancia($lat_usuario, $lon_usuario, $a['lat'], $a['lon']);
    $dist_b = calcular_distancia($lat_usuario, $lon_usuario, $b['lat'], $b['lon']);
    return $dist_a <=> $dist_b;
});

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TANDTOUR</title>
    <link rel="stylesheet" href="css/cssubicaciones.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const userLat = <?= json_encode($lat_usuario); ?>;
        const userLon = <?= json_encode($lon_usuario); ?>;
    </script>
    
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
</head>
<body>
<div class="logo">
    <img src="imagenes/logo.png" alt="Logo" />
</div>
<header>
    <nav class="nav-buttons">
        <a href="inicio.php"><i class="fas fa-home"></i><span>INICIO</span></a>
        <a href="Mapa2.php"><i class="fas fa-map-marker-alt"></i><span>MAPA</span></a>
        <a href="armaragenda.php"><i class="far fa-calendar-alt"></i><span>¡ARMA TU AGENDA!</span></a>
        <a href="clima.php"><i class="fas fa-sun"></i><span>CLIMA</span></a>
        <a href="noticias.php" class="noticias"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
        <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
    </nav>
</header>
<main>
    <section class="ubicaciones">
        <?php foreach ($ubicaciones as $ubicacion): ?>
            <div class="ubicacion" 
                 id="ubicacion<?= $ubicacion['id_actividad']; ?>" 
                 data-lat="<?= $ubicacion['lat']; ?>" 
                 data-lon="<?= $ubicacion['lon']; ?>">
                <?= htmlspecialchars($ubicacion['nombre']); ?>
                <button class="directions-btn" data-lat="<?= $ubicacion['lat']; ?>" data-lon="<?= $ubicacion['lon']; ?>">
                    Indicaciones (<?= $ubicacion['distancia']; ?> km)
                </button>
            </div>
        <?php endforeach; ?>
    </section>
    <section class="mapa">
        <div id="map" style="height: 600px;"></div>
        
    </section>
    
    <script src="js/jsubic.js?v=<?= time(); ?>"></script> <!-- Enlace al archivo JS separado -->
</main>
</body>
</html>

