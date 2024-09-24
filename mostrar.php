<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tandtour";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['email'])) {
    header('Location: index.php');
    exit();
}

// Obtener los datos del formulario
$nombres = $_POST["nombres"];
$apellido = $_POST["apellido"];
$email = $_POST["email"];
$contraseña = $_POST["contraseña"];
$id_usuario = $_POST["id_usuario"];
$foto_actual = $_POST["foto_actual"];
$target_dir = "uimg/";

if (isset($_FILES["foto"]) && $_FILES["foto"]["name"] !== "") {
    $target_file = $target_dir . time() . basename($_FILES["foto"]["name"]);
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    $foto = $target_file;
} else {
    $foto = $foto_actual;
}

// Eliminar la foto si se selecciona la opción
if (isset($_POST['eliminar_foto']) && $_POST['eliminar_foto'] == '1') {
    if ($foto_actual !== "imagenes/perfil.jpg" && file_exists($foto_actual)) {
        unlink($foto_actual);
    }
    $foto = "imagenes/perfil.jpg";
}

// Hash de la contraseña
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

if (intval($id_usuario) < 0) {
    // Insertar nuevo usuario
    $verificar = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($verificar);
    if ($result->num_rows > 0) {
        header('Location: registro.php?error=1');
        exit;
    } else {
        $sql = "INSERT INTO usuarios (nombres, apellido, email, foto, contraseña) VALUES ('$nombres', '$apellido', '$email', '$foto', '$contraseña_hash')";
        if ($conn->query($sql) === TRUE) {
            // Obtener el id_usuario del nuevo usuario insertado
            $id_usuario = $conn->insert_id;
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['user_name'] = $nombres;
            $_SESSION['user_photo'] = $foto;
            $_SESSION['email'] = $email;
            header('Location: index.php');
            exit;
        } else {
            echo "Error al insertar registro: " . $conn->error;
        }
    }
} else {
    // Actualizar usuario existente
    $sql = "UPDATE usuarios SET nombres = '$nombres', apellido = '$apellido', email = '$email', contraseña = '$contraseña_hash', foto = '$foto' WHERE id_usuario = '$id_usuario'";
    if ($conn->query($sql) === TRUE) {
        // Actualizar variables de sesión para reflejar los cambios inmediatamente
        $_SESSION['user_name'] = $nombres;
        $_SESSION['user_photo'] = $foto;
        $_SESSION['email'] = $email;
        header('Location: ajustes.php');
        exit;
    } else {
        echo "Error al actualizar registro: " . $conn->error;
    }
}

$conn->close();
?>
