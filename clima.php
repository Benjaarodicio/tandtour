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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

    <link rel="stylesheet" href="css/estilosclima.css?v=<?= time(); ?>">
</head>
<body>
<div class="logo">
        <img src="imagenes/logo.png" alt="Logo" />
    </div>
    <header>
        <nav class="nav-buttons">
            <a href="inicio.php"><i class="fas fa-home"></i><span>INICIO</span></a>
            <a href="Mapa2.php"><i class="fas fa-map-marker-alt"></i><span>MAPA</span></a>
            <a href="armaragenda.php" ><i class="far fa-calendar-alt"></i><span>¡ARMA TU AGENDA!</span></a>
            <a href="clima.php" class="active" ><i class="fas fa-sun"></i><span>CLIMA</span></a>
            <a href="noticias.php" class="noticias"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
            <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
        </nav>
    </header>
    <div class="container">
        <div class="weather-side">
            <div class="weather-gradient"></div>
            <div class="date-container">
                <h2 class="date-dayname"></h2>
                <span class="date-day"></span>
                <i class="fa-solid fa-location-dot"></i>
                <span class="location"></span>
            </div>
            <div class="weather-container">
                <span class="weather-icon"></span>
                <h1 class="weather-temp"></h1>
                <h3 class="weather-desc"></h3>
            </div>
        </div>
        <div class="info-side">
            <div class="today-info-container">
                <div class="today-info">
                    <div class="humidity">
                        <span class="title"><i class="fa-solid fa-droplet"></i> HUMEDAD</span>
                        <span class="value"></span>
                        <div class="clear"></div>
                    </div>
                    <div class="wind">
                        <span class="title"><i class="fa-solid fa-wind"></i> VIENTO</span>
                        <span class="value"></span>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="week-container">
                <ul class="week-list">
                    <li>
                        <span class="day-name"></span>
                        <span class="day-temp"></span>
                        <span class="day-icon"></span>
                    </li>
                    <li>
                        <span class="day-name"></span>
                        <span class="day-temp"></span>
                        <span class="day-icon"></span>
                    </li>
                    <li>
                        <span class="day-name"></span>
                        <span class="day-temp"></span>
                        <span class="day-icon"></span>
                    </li>
                    <li>
                        <span class="day-name"></span>
                        <span class="day-temp"></span>
                        <span class="day-icon"></span>
                    </li>
                    <li>
                        <span class="day-name"></span>
                        <span class="day-temp"></span>
                        <span class="day-icon"></span>
                    </li>
                  
                    <div class="clear"></div>
                </ul>
            </div>
            <div class="location-container">
                
                <input class="location-input" type="text" id="city" value="Tandil">
            </div>
        </div>

    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="js/jsclima.js"></script>
</body>
</html>