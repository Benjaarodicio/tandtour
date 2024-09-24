<?php
session_start();

if (!isset($_SESSION['email'])) {  //verifica si hay un email, sino te manda al index
    header('Location: index.php'); //linea superimportante 
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TANDTOUR</title>
    <link rel="stylesheet" href="css/principalestilos.css?v=<?= time(); ?>">
</head>
<body>
    <div class="video-background">
        <video autoplay muted loop id="bg-video">
            <source src="imagenes/fondo.mp4" type="video/mp4">
         
        </video>
    </div>
    <div class="content">
        <div class="main-content">
            <h1>Bienvenido a TANDTOUR</h1>
            <p>La pagina que te va a ayudar a armar tu agenda en tu hospedia en la ciudad</p>
            <button onclick="location.href='inicio.php'">Haz clic aquí</button>
        </div>
    </div>
</body>
</html>
