<?php
// Verificar si no hay cookie ni sesión de usuario activa
if (!isset($_COOKIE['usuario']) && !isset($_SESSION['usuario'])) {
    header('Location: index.html');
    exit();
}
?>