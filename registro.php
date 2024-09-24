<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";
$conn = new mysqli($servername, $username, $password, $dbname);

$id_usuario = -1;
$name = "";
$app = "";
$email = "";
$foto = "imagenes/perfil.jpg"; // Foto por defecto

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
    if ($re = mysqli_query($conn, $sql)) {
        $r = mysqli_fetch_array($re);
        $name = $r['nombres'];
        $app = $r['apellido'];
        $email = $r['email'];
        $id_usuario = $r['id_usuario'];
        $foto = $r['foto'];
        $contraseña = $r['contraseña'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/cssregistro.css?v=<?= time(); ?>">
</head>
<body>
    <div class="formulario">
        <h1 class="rojo">INGRESAR NUEVO USUARIO/EDITAR</h1>
        <form class="formulario-principal" action="mostrar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
            <div class="field">
                <label>Nombre:</label>
                <input type="text" name="nombres" required="required" value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="field">
                <label>Apellido:</label>
                <input type="text" name="apellido" required="required" value="<?= htmlspecialchars($app) ?>">
            </div>
            <div class="field">
                <label>Email:</label>
                <input type="email" name="email" required="required" value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="field field-imagen">
                <label>Foto:</label>
                <input class="input-imagen" type="file" name="foto">
                <input type="hidden" name="foto_actual" value="<?= htmlspecialchars($foto) ?>">
            </div>
            <div class="contenedor-imagen">
                <img id_usuario="imagen-perfil" src="<?= htmlspecialchars($foto) ?>" width="auto" height="150px">
                <?php if ($foto !== "imagenes/perfil.jpg"): ?>
                    <div class="field">
                        <label>Eliminar foto de perfil:</label>
                        <input type="checkbox" name="eliminar_foto" value="1">
                    </div>
                <?php endif; ?>
            </div>
            <div class="field">
                <label>Contraseña:</label>
                <input type="password" name="contraseña" required="required">
            </div>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error">El correo que ingresaste ya está registrado</p>
            <?php } ?>
            <button type="submit">Guardar</button>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('input[type="file"]').change(function () {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            $('#imagen-perfil').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    });
                });
            </script>
        </form>
    </div>
    <form action="<?= $id_usuario > 0 ? 'ajustes.php' : 'index.php' ?>">
        <button>Volver</button>
    </form>
</body>
</html>
