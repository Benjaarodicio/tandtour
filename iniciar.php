<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (!(isset($_POST["email"]) || isset($_POST["contraseña"]))) {
    header('Location: index.php');
    exit();
} //Acceso sin autenticación
$Email = $_POST["email"];
$contraseña = $_POST["contraseña"];

// Consulta para obtener los datos del usuario
$sql = "SELECT id_usuario, Nombres, foto, contraseña FROM usuarios WHERE Email = '$Email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $contraseña_hash = $row["contraseña"];

    if (password_verify($contraseña, $contraseña_hash)) {
        $_SESSION['email'] = $Email;
        $_SESSION['user_id'] = $row["id_usuario"];
        $_SESSION['user_name'] = $row["Nombres"];
        $_SESSION['user_photo'] = $row["foto"];
        header('Location: principal.php');
        exit();
    } else {
        header('Location: index.php?error=1'); //contraseña incorrecta
        exit();
    }
} else {
    header('Location: index.php?error=1'); //email incorrecto
    exit();
}
?>