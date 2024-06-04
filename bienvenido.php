<?php
session_start();

// Verificar si hay una sesión activa o una cookie
if (!isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['usuario'])) {
        // Si existe una cookie, reiniciar la sesión
        $_SESSION['usuario'] = $_COOKIE['usuario'];
    } else {
        header('Location: index.html');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body>
    <h1>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    <a href="index.html?logout=true">Cerrar sesión</a>
</body>
</html>
