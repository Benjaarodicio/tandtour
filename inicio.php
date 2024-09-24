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
    <link rel="stylesheet" href="css/inicioestilos.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

    <div class="logo">
        <img src="imagenes/logo.png" alt="Logo" />
    </div>
    <header>
        <nav class="nav-buttons">
            <a href="inicio.php" class="active"><i class="fas fa-home"></i><span>INICIO</span></a>
            <a href="Mapa2.php"><i class="fas fa-map-marker-alt"></i><span>MAPA</span></a>
            <a href="armaragenda.php"><i class="far fa-calendar-alt"></i><span>¡ARMA TU AGENDA!</span></a>
            <a href="clima.php"><i class="fas fa-sun"></i><span>CLIMA</span></a>
            <a href="noticias.php" class="noticias"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
            <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
        </nav>
    </header>

    <div class="container">
        <a href="atracciones.php" class="round-button">Atracciones Turísticas</a>
        <div class="gallery">
            <a href="#" class="open-modal" data-modal="modalMovediza">
                <img src="https://cloudfront-us-east-1.images.arcpublishing.com/infobae/2RFK2RD5KZAS5GMCWSZRKZZPIM.jpg" alt="Piedra Movediza">
            </a>
            <a href="#" class="open-modal" data-modal="modalCalvario">
                <img src="https://media-cdn.tripadvisor.com/media/photo-s/06/d9/f1/7d/monte-calvario.jpg" alt="Monte Calvario">
            </a>
            <a href="#" class="open-modal" data-modal="modalParque">
                <img src="https://www.infoviajera.com/wp-content/uploads/2021/05/Argentina-Tandil-Cerro-Parque-Independencia-Castillo-Panoramica.jpg" alt="Parque Independencia">
            </a>
        </div>
    </div>
    <div class="text-overlay">TANDTOUR</div>

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

    <!-- Modal Parque Independencia -->
    <div id="modalParque" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img src="https://www.infoviajera.com/wp-content/uploads/2021/05/Argentina-Tandil-Cerro-Parque-Independencia-Castillo-Panoramica.jpg" alt="Parque Independencia">
            <h2>Parque Independencia</h2>
            <p>Información sobre el Parque Independencia. Un parque histórico con un castillo en la cima que ofrece una vista hermosa de la ciudad de Tandil.</p>
        </div>
    </div>

    <script src="js/jsinicio.js?v=<?= time(); ?>"></script>

</body>

</html>
