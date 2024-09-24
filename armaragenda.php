<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['email']) || !isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_usuario = $_SESSION['user_id'];

// Verificar si el usuario ya completó la encuesta
$sql = "SELECT * FROM itinerario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0 && !isset($_SESSION['allow_new_agenda'])) {
    // Si la agenda ya está completada y no se permite una nueva, redirigir a completada.php
    header('Location: completada.php');
    exit();
} elseif (isset($_SESSION['allow_new_agenda'])) {
    // Permitir reemplazo de la agenda, eliminar la existente y continuar con la nueva
    $sql = "DELETE FROM itinerario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    unset($_SESSION['allow_new_agenda']);
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuestionario de Turista</title>
    <link rel="stylesheet" href="css/estilosagenda.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        <h1>Cuestionario Para Saber Las Preferencias De Nuestros Turistas</h1>
        <form id="quizForm" action="subidarespuestas.php" method="POST">
            <div class="question-container active" id="question1">
                <h2>Pregunta 1: ¿Quien Te Acompaña?</h2>
                <div class="options">
                    <div class="option" data-value="Solo">Solo</div>
                    <div class="option" data-value="Familia">Familia</div>
                    <div class="option" data-value="Pareja">Pareja</div>
                    <div class="option" data-value="Contingente">Contingente</div>
                </div>
                <button type="button" class="nextBtn">Siguiente</button>
            </div>
            <div class="question-container" id="question2">
                <h2>Pregunta 2: ¿Cantidad de personas que vienen?</h2>
                <div class="options">
                    <div class="option" data-value="1">1</div>
                    <div class="option" data-value="2">2</div>
                    <div class="option" data-value="3">3</div>
                    <div class="option" data-value="4">4</div>
                    <div class="option" data-value="+5">+5</div>
                </div>
                <button type="button" class="prevBtn">Volver atrás</button>
                <button type="button" class="nextBtn">Siguiente</button>
            </div>
            <div class="question-container" id="question3">
                <h2>Pregunta 3: ¿Tiene Alguna dificultad?</h2>
                <div class="options">
                    <div class="option" data-value="0">Sin Dificultades</div>
                    <div class="option" data-value="1">Visual</div>
                    <div class="option" data-value="0">Auditiva</div>
                    <div class="option" data-value="1">Motriz</div>
                </div>
                <button type="button" class="prevBtn">Volver atrás</button>
                <button type="button" class="nextBtn">Siguiente</button>
            </div>
            <div class="question-container" id="question4">
                <h2>Pregunta 4: ¿Preferencias de lugares a visitar?</h2>
                <div class="options">
                <div class="option" data-value="2">Lugares Al Aire libre</div>
                <div class="option" data-value="3">Lugares Cerrados</div>
                <div class="option" data-value="4">Todos</div>
                </div>  
                <button type="button" class="prevBtn">Volver atrás</button> 
                <button type="button" class="nextBtn">Siguiente</button>
            </div>
            <div class="question-container" id="question5">
                <h2>Pregunta 5: ¿Duración de la estadia?</h2>
                <div class="options">
                    <div class="option" data-value="1 día">1 día</div>
                    <div class="option" data-value="2 días">2 días</div>
                    <div class="option" data-value="3 días">3 días</div>
                    <div class="option" data-value="4 días">4 días</div>
                    <div class="option" data-value="+5 días">+5 días</div>
                </div>
                <button type="button" class="prevBtn">Volver atrás</button>
                <button type="button" class="nextBtn">Siguiente</button>
            </div>
            <div class="question-container" id="question6">
                <h2>Pregunta 6: ¿Cómo te manejas?</h2>
                <div class="options">
                    <div class="option" data-value="Caminando">Caminando</div>
                    <div class="option" data-value="Vehículo">Vehículo</div>
                    <div class="option" data-value="Bicicleta">Bicicleta</div>
                </div>
                <button type="button" class="prevBtn">Volver atrás</button>
                <button type="button" class="nextBtn">Siguiente</button>
            </div>
            <div class="question-container" id="question7">
        <h2>Pregunta 7: ¿Guardar mi ubicación actual?</h2>
        <button type="button" id="saveLocation">Guardar mi ubicación</button>
        <input type="hidden" id="ubicacion" name="ubicacion">
<p id="locationStatus"></p>
        <button type="button" class="prevBtn">Volver atrás</button>
        <button type="submit" id="submitBtn">Enviar</button>
    </div>
        <div id="result" class="result"></div>
    </div>
    <script src="js/jsagenda.js?v=<?= time(); ?>"></script>
</body>
</html> 
