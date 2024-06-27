<?php
session_start();

if (!isset($_SESSION['usuario']) && !isset($_COOKIE['usuario'])) {
    header('Location: index.html');
    exit();
}


// Cerrar sesión
if (isset($_GET['cerrar_sesion'])) {
    $_SESSION = array();
    
    session_unset();
    session_destroy();
    
    if (isset($_COOKIE['usuario'])) {
        setcookie('usuario', '', time() - 3600, '/');
    }
    
    if (isset($_COOKIE['administrador'])) {
        setcookie('administrador', '', time() - 3600, '/');
    }
    
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Administrador</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{
            background-color: #FAEBD7;       
            font-family: 'medieval', cursive;
        }
        .botones-centrados {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .btn {
            background-color: #DEB887; /* Un color que combina con el fondo */
            color: white;
            margin-bottom: 10px;
            padding: 10px 20px; /* Hace los botones más grandes */
            font-size: 1.2em;
        }

        .encabezado-centrado {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <header class="bg-light p-3 mb-4 d-flex justify-content-between align-items-center">
        <nav class="encabezado-centrado">
            <a class="mx-2" href="?cerrar_sesion=1" id="cerrar-sesion">Cerrar Sesión</a>
            <a class="mx-2" href="inicio_admin.php">Inicio Admin</a>
        </nav>
    </header>
    <div class="botones-centrados">
        <a class="btn" href="tabla_productos.php">Ver Productos</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
