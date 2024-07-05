<?php
session_start();
// Verificar si no hay cookie ni sesión de administrador activa
if (!isset($_COOKIE['administrador']) && !isset($_SESSION['administrador'])) {
    header('Location: inicio.php');
    exit();
}

// Verificar si hay cookie o sesión de usuario (no administrador) activa
if (isset($_COOKIE['usuario']) || isset($_SESSION['usuario'])) {
    echo '<script>alert("No tienes permiso para acceder a esta página."); window.location.href = "inicio.php";</script>';
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
    
    header('Location: index.php');
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
        .btn-custom {
            background-color: #DEB887; /* Un color que combina con el fondo */
            color: white;
            margin-bottom: 10px;
            padding: 10px 20px; /* Hace los botones más grandes */
            font-size: 1.2em;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            color: black;
            transform: scale(1.1);
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
        <form action="tabla_productos.php" method="post">
            <button id="btn_enviar" type="submit" class="btn btn-custom">Ver Productos</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script>
        document.onkeydown = function(e) {
            if ((e.ctrlKey && 
                (e.keyCode === 85 || // Ctrl+U
                e.keyCode === 117)) || // Ctrl+F6
                (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
                e.keyCode === 123) { // F12
                swal("Deja de intentar robar puntos, pareces muerto de hambre");
                return false;
            }
        };

        document.oncontextmenu = function(e) {
            swal("Deja de intentar robar puntos, pareces muerto de hambre");
            return false;
        };
	</script>
</body>
</html>
