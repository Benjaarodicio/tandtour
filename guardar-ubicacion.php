<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$id_usuario = $_SESSION['user_id'];

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preparar y ejecutar la inserción
$sql = "INSERT INTO itinerario (id_usuario, ubicacion) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$ubicacion = isset($_POST['ubicacion']) ? $_POST['ubicacion'] : null;

$stmt->bind_param('is', $id_usuario, $ubicacion);

if ($stmt->execute()) {
    echo "Ubicación guardada correctamente.";
} else {
    echo "Error al guardar la ubicación: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
