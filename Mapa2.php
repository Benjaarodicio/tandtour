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
    <!-- Enlace a la hoja de estilos de Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/mapa2.css?v=<?= time(); ?>">

</head>
<body>

<div class="logo">
        <img src="imagenes/logo.png" alt="Logo" />
    </div>
    <header>
<nav class="nav-buttons">
    <a href="inicio.php"><i class="fas fa-home"></i><span>INICIO</span></a>
    <a href="Mapa2.php" class="active"><i class="fas fa-map-marker-alt"></i><span>MAPA</span></a>
    <a href="armaragenda.php"><i class="far fa-calendar-alt"></i><span>¡ARMA TU AGENDA!</span></a>
    <a href="clima.php"><i class="fas fa-sun"></i><span>CLIMA</span></a>
    <a href="noticias.php" class="noticias"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
    <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
</nav>
    </header>

        <div id="map"></div>
        

<!-- Script de Leaflet.js -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="js/jsmapa2.js"></script> <!-- Archivo para el código JavaScript -->
</body>
</html>
