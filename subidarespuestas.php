<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_usuario = $_SESSION['user_id'];

$tipogrupo = $_POST['question1'] ?? '';
$personas = $_POST['question2'] ?? '';
$dificultades = $_POST['question3'] ?? '';
$tipoactividad = $_POST['question4'] ?? '';
$duracion = $_POST['question5'] ?? '';
$movilidad = $_POST['question6'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? ''; // Ubicación guardada

// Inicializar latitud y longitud
$latitud = $longitud = null;

// Verificar si la ubicación está presente y dividirla
if ($ubicacion) {
    $coords = explode(',', $ubicacion);
    if (count($coords) === 2) {
        $latitud = $coords[0];
        $longitud = $coords[1];
    }
}

// Eliminar la agenda existente antes de insertar una nueva
if (isset($_SESSION['allow_new_agenda'])) {
    $sql = "DELETE FROM itinerario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $stmt->close();
    unset($_SESSION['allow_new_agenda']);
}

// Preparar la consulta para insertar datos
$sql = $conn->prepare("
    INSERT INTO itinerario (tipogrupo, personas, dificultades, tipoactividad, duracion, movilidad, id_usuario, latitud, longitud)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if ($sql === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

// Asignar los valores a los parámetros de la consulta
$sql->bind_param('ssssssdds', $tipogrupo, $personas, $dificultades, $tipoactividad, $duracion, $movilidad, $id_usuario, $latitud, $longitud);

if ($sql->execute()) {
    header('Location: ubicaciones.php');
    exit;
} else {
    echo "Error de ejecución: " . $sql->error;
}

$sql->close();
$conn->close();
?>
