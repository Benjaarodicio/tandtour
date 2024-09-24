<?php
session_start(); // Iniciar la sesión si todavia no está iniciada
if (!isset($_SESSION['email'])) {  //verifica si hay un email, sino te manda al index
    header('Location: index.php'); //linea superimportante 
    exit();
}
// Destruir todas las variables de sesión


// Finalmente, destruir la sesión
session_destroy();

echo 'La sesión se ha cerrado correctamente.';

// Redireccionar a la página de inicio de sesión 
header("Location: index.php");

exit();
?>