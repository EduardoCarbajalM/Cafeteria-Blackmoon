<?php
session_start();

// Verificar si no hay cookie ni sesión de usuario activa
if (!isset($_COOKIE['usuario']) && !isset($_SESSION['usuario'])) {
    header('Location: index.html');
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
<body>
    <header class="bg-light p-3 mb-4 d-flex justify-content-between align-items-center">
        <img src="img/usuario.png" alt="mini menu usuario" class="rounded-circle">
        <nav>
            <a class="mx-2" href="inicio.php">Inicio</a>
            <a class="mx-2" href="menu.php">Menús</a>
            <a class="mx-2" href="promos.php">Promos</a>
            <a class="mx-2" href="#" id="logout">Cerrar Sesión</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script src="minimenu.js"></script>
<script src="cerrarsesion.js"></script>
</html>