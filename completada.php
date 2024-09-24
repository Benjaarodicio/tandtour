<?php
session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['replace_agenda'])) {
    $_SESSION['allow_new_agenda'] = true;
    header('Location: armaragenda.php'); // Redirigir al formulario de la agenda
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Completa</title>
    <link rel="stylesheet" href="css/estilosagenda.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script>
        function confirmReplace() {
            return confirm("¿Estás seguro de que deseas reemplazar tu agenda existente con una nueva?");
        }
    </script>
</head>
<body>
<div class="logo">
        <img src="imagenes/logo.png" alt="Logo" />
    </div>
    <header>
        <nav class="nav-buttons">
            <a href="inicio.php"><i class="fas fa-home"></i><span>INICIO</span></a>
            <a href="Mapa2.php"><i class="fas fa-map-marker-alt"></i><span>MAPA</span></a>
            <a href="armaragenda.php" class="agenda active" ><i class="far fa-calendar-alt"></i><span>¡ARMA TU AGENDA!</span></a>
            <a href="clima.php"><i class="fas fa-sun"></i><span>CLIMA</span></a>
            <a href="noticias.php" class="noticias"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
            <a href="ajustes.php" class="ajustes"><i class="fas fa-cog"></i></a>
        </nav>
    </header>
    <div class="container">
        <h1>Ya has completado la agenda</h1>
        <p>¿Deseas reemplazar tu agenda existente con una nueva?</p>
        <form method="POST" action="" onsubmit="return confirmReplace();">
            <button type="submit" name="replace_agenda">Sí, reemplazar</button>
        </form>
        <form action="ubicaciones.php" method="GET">
            <button type="submit">Ir a la Agenda</button>
        </form>
    </div>
</body>
</html>
