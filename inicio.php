<?php
session_start();

// Verificar si no hay cookie ni sesión de usuario activa
if (!isset($_COOKIE['usuario']) && !isset($_SESSION['usuario'])) {
    header('Location: index.php');
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="minimenu.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .grid-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            transition: transform 0.3s;
            height: 300px; /* Altura fija para todas las cajas */
        }
        .grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .grid-item:hover {
            transform: scale(1.05);
        }
        .grid-item a {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            text-indent: -9999px; /* Ocultar el texto del enlace */
        }
    </style>
</head>
<body onload="inicializarPagina()">
    <header class="bg-light p-3 mb-4 d-flex justify-content-between align-items-center">
        <img src="img/usuario.png" alt="mini menu usuario" class="rounded-circle">
        <nav>
            <a class="mx-2" href="inicio.php">Inicio</a>
            <a class="mx-2" href="menu.php">Menús</a>
            <a class="mx-2" href="promos.php">Promos</a>
            <a class="mx-2" href="?cerrar_sesion=1" id="cerrar-sesion">Cerrar Sesión</a>
        </nav>
    </header>
    
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="grid-item">
                    <img src="img/imenu.jpg" alt="">
                    <a href="menu.php">Menu</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="grid-item">
                    <img src="img/bm.jpg" alt="">
                    <a href="descripcion.php">Descripción</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="grid-item">
                    <img src="img/promos.jpg" alt="">
                    <a href="promos.php">Promos</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 mb-4">
                <div class="grid-item">
                    <img src="img/TyC.jpg" alt="">
                    <a href="terminosycondiciones.php">Términos y Condiciones</a>
                </div>
            </div>
        </div>
    </div>
      <script>
        function inicializarPagina() {
            const iconoAlternar = document.getElementById('iconoAlternar');
            iconoAlternar.src = 'img/001-visibilidad.png';
            iconoAlternar.alt = 'Mostrar contraseña';

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
        }
  	</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script src="minimenu.js"></script>
</html>