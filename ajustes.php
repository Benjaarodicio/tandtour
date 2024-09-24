<?php
session_start();

if (!isset($_SESSION['email'])) {  //verifica si hay un email, sino te manda al index
    header('Location: index.php'); //linea superimportante 
    exit;
}

$nombreUsuario = $_SESSION['user_name'];
$fotoUsuario = $_SESSION['user_photo'];
$id_usuario = $_SESSION['user_id'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("ERROR en la conexión a la DB: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TANDTOUR</title>
    <link rel="stylesheet"  href="css/ajustesestilos.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
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
            <a href="armaragenda.php"><i class="far fa-calendar-alt"></i><span>¡ARMA TU AGENDA!</span></a>
            <a href="clima.php"><i class="fas fa-sun"></i><span>CLIMA</span></a>
            <a href="noticias.php" class="noticias"><i class="far fa-newspaper"></i><span>NOTICIAS</span></a>
            <a href="ajustes.php" class="ajustes active "><i class="fas fa-cog"></i></a>
        </nav>
    </header>
    <div class="container">
        <div id="contenedor-form">

            <div class="info">
                <div>
                    
            <div class="foto-perfil">
                <?php if (!empty($fotoUsuario) && file_exists($fotoUsuario)): ?>
                  <img src="<?php echo $fotoUsuario; ?>" alt="Foto de perfil" class="foto-perfil">
                <?php else: ?>
                  <img src="perfil.jpg" alt="Foto de perfil predeterminada" class="foto-perfil">
                <?php endif; ?>
              </div>

              <div class="nombre-usuario">
              <label>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></label>
</div>

                </div>
                <div class="boton-editar">
                <?php
$query = mysqli_query($conn, "SELECT * FROM usuarios") or die(mysqli_error($conn));

// Asegúrate de que la sesión esté iniciada y el usuario esté autenticado
if (isset($_SESSION['user_id'])) {
    while ($row = mysqli_fetch_array($query)) {
        // Verifica que el id_usuario en la base de datos coincida con el id del usuario de la sesión
        if ($row["id_usuario"] == $_SESSION['user_id']) {
            // Corrige el nombre del parámetro a 'id_usuario' en el enlace
            echo "<button><a href='registro.php?id_usuario=" . $row['id_usuario'] . "'>Editar</a></button>";
        }
    }
} else {
    echo "No hay un usuario autenticado en la sesión.";
}
?>

                </div>

              </form>
              <form  action="cerrarsesion.php" method="POST" enctype="multipart/form-data">
                <button class="cerrarsesion" name="boton" value="Usuarios">cerrar sesion</button>
              </form>
            </div>


        </div>
    </div>
    
      


</body>

</html>