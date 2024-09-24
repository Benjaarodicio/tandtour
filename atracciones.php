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
    <title>Descubre Tandil</title>
    <link rel="stylesheet" href="css/atraccionesestilos.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="imagenes/logo.png" alt="Logo" />
        </div>
        <nav class="nav-buttons">
            <a href="inicio.php"><i class="fas fa-home"></i>INICIO</a>
            <a href="Mapa2.php"><i class="fas fa-map-marker-alt"></i>MAPA</a>
            <a href="formulario.html"><i class="far fa-calendar-alt"></i>¡ARMA TU AGENDA!</a>
            <a href="clima.php"><i class="fas fa-sun"></i>CLIMA</a>
            <a href="#" class="noticias"><i class="far fa-newspaper"></i>NOTICIAS</a>
            <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
        </nav>
    </header>
    <div class="container">
        <div id="contenedor-form">
            <section id="atracciones">
                <h2>Atracciones Imperdibles</h2>
                <div class="gallery">
                    <a href="#" class="open-modal" data-modal="modalMovediza">
                        <img src="https://cloudfront-us-east-1.images.arcpublishing.com/infobae/2RFK2RD5KZAS5GMCWSZRKZZPIM.jpg" alt="Piedra Movediza">
                    </a>
                    <a href="#" class="open-modal" data-modal="modalCalvario">
                        <img src="https://media-cdn.tripadvisor.com/media/photo-s/06/d9/f1/7d/monte-calvario.jpg" alt="Monte Calvario">
                    </a>
                    <a href="#" class="open-modal" data-modal="modalLago">
                        <img src="https://descubrirturismo.com/wp-content/uploads/2019/05/lago-del-fuerte-tandil-buenos-aires.jpg" alt="Lago del Fuerte">
                    </a>
                    <a href="#" class="open-modal" data-modal="modalParque">
                        <img src="https://www.infoviajera.com/wp-content/uploads/2021/05/Argentina-Tandil-Cerro-Parque-Independencia-Castillo-Panoramica.jpg" alt="Parque Independencia">
                    </a>
                    <a href="#" class="open-modal" data-modal="modalCascada">
                        <img src="https://i0.wp.com/leerdelviaje.com/wp-content/uploads/2023/08/20230816_160856-scaled.jpg?resize=1085%2C530&ssl=1" alt="La Cascada">
                    </a>
                    <a href="#" class="open-modal" data-modal="modalCentinela">
                        <img src="https://www.welcomeargentina.com/paseos/aerosilla_el_centinela/cerro-centinela-tandil-2.jpg" alt="Cerro El Centinela">
                    </a>
                </div>
                <p class="description">
                    Visita la icónica Piedra Movediza, el Monte Calvario, el hermoso Lago del Fuerte, el histórico Parque Independencia y las impresionantes Sierras de Tandil.
                </p>
                <div class="cta">
                    <a href="inicio.php"><button>Volver Atrás</button></a>
                </div>
            </section>
        </div>
    </div>

    <!-- Modales -->
    <!-- Modal Piedra Movediza -->
    <div id="modalMovediza" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://cloudfront-us-east-1.images.arcpublishing.com/infobae/2RFK2RD5KZAS5GMCWSZRKZZPIM.jpg" alt="Piedra Movediza">
            <h2>Piedra Movediza</h2>
            <p>Información sobre la Piedra Movediza. Esta icónica formación rocosa es un símbolo de la ciudad de Tandil, conocida por su historia única y su sorprendente equilibrio natural.</p>
        </div>
    </div>

    <!-- Modal Monte Calvario -->
    <div id="modalCalvario" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://media-cdn.tripadvisor.com/media/photo-s/06/d9/f1/7d/monte-calvario.jpg" alt="Monte Calvario">
            <h2>Monte Calvario</h2>
            <p>Información sobre el Monte Calvario. Este lugar es un importante sitio de peregrinación y ofrece vistas panorámicas impresionantes desde su cima.</p>
        </div>
    </div>

    <!-- Modal Lago del Fuerte -->
    <div id="modalLago" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://descubrirturismo.com/wp-content/uploads/2019/05/lago-del-fuerte-tandil-buenos-aires.jpg" alt="Lago del Fuerte">
            <h2>Lago del Fuerte</h2>
            <p>Información sobre el Lago del Fuerte. Un lugar perfecto para disfrutar de actividades al aire libre y apreciar la naturaleza en su esplendor.</p>
        </div>
    </div>

    <!-- Modal Parque Independencia -->
    <div id="modalParque" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://www.infoviajera.com/wp-content/uploads/2021/05/Argentina-Tandil-Cerro-Parque-Independencia-Castillo-Panoramica.jpg" alt="Parque Independencia">
            <h2>Parque Independencia</h2>
            <p>Información sobre el Parque Independencia. Un parque histórico con un castillo en la cima que ofrece una vista hermosa de la ciudad de Tandil.</p>
        </div>
    </div>

    <!-- Modal La Cascada -->
    <div id="modalCascada" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://i0.wp.com/leerdelviaje.com/wp-content/uploads/2023/08/20230816_160856-scaled.jpg?resize=1085%2C530&ssl=1" alt="La Cascada">
            <h2>La Cascada</h2>
            <p>Información sobre La Cascada. Un destino natural impresionante, ideal para caminatas y disfrutar de la serenidad de la naturaleza.</p>
        </div>
    </div>

    <!-- Modal Cerro El Centinela -->
    <div id="modalCentinela" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://www.welcomeargentina.com/paseos/aerosilla_el_centinela/cerro-centinela-tandil-2.jpg" alt="Cerro El Centinela">
            <h2>Cerro El Centinela</h2>
            <p>Información sobre el Cerro El Centinela. Una formación natural destacada, perfecta para disfrutar de un día de excursión.</p>
        </div>
    </div>

<script src="js/jsatracciones.js?v=<?= time(); ?>"></script>
</body>

</html>
