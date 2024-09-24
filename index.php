<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/csslogin.css">
    <title>TANDTOUR</title>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Inicio de Sesión</title>




    </head>

<body>
    <div id="contenedor-form">
        <h1> INICIAR SESIÓN</h1>
        <form action="iniciar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?= $ID ?>">
            <i class="fa-solid fa-user"></i>            
            <input name="email" type="email" required="required" placeholder="Correo electronico">
            <br>
            <input name="contraseña" type="password" required="required" placeholder="Contraseña">
            <br>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error">Usuario o contraseña incorrectos</p>
            <?php } ?>
            <!-- Errores -->
            <!--esto envía el formulario-->
            <button id="button-iniciar" type="submit">Iniciar Sesión</button>

            <br>
            <br>

            <label>
                <h3>No estas registrado?</h3>
            </label>

            <button onclick="location.href='registro.php'">Registrar</button>
        </form>
    </div>

    <!-- Se va a procesar en iniciar.php y se enviará por POST-->
</body>

</html>