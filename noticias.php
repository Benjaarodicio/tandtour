<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Noticias</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/cssnoticias.css?v=<?= time(); ?>">
    <script src="js/jsnoticias.js"></script>
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
            <a href="noticias.php" class="noticias active"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
            <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
        </nav>
    </header>
    <main class="container">
    <section class="featured-news">
    <div class="card">
        <a href="#" class="card">
            <img id="featured-img" src="fondoimg.jpg" alt="Destacado" class="card-img-top">
            <div class="card-body">
                <h2 id="featured-title" class="card-title">BUSCANDO NOTICIAS...</h2>
                <p id="featured-desc" class="card-text"></p>
            </div>
        </a>
    </div>


            <aside class="latest-news">
                <h2>Últimas Noticias</h2>
                <div class="news-list">
                    <a href="#" class="news-item">
                        <img src="fondoimg.jpg" alt="Noticia 1" class="news-img">
                        <div>
                            <h5>BUSCANDO NOTICIAS...</h5>
                            <small class="text-muted"></small>
                        </div>
                    </a>
                    <!-- Agrega más noticias según sea necesario -->
                </div>
            </aside>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
