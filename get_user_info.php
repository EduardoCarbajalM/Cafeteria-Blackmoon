<?php
session_start();
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

if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['SERVER_NAME']) {
    header("Location: ?cerrar_sesion=1");
    exit();
}

include 'conexion_bd.php';

$usuario = null;

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} elseif (isset($_COOKIE['usuario'])) {
    $usuario = $_COOKIE['usuario'];
}

if ($usuario) {
    $query = "SELECT Nombre, saldo FROM usuarios WHERE Nombre = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInfo = $result->fetch_assoc();

    echo json_encode([
        'nombre' => $userInfo['Nombre'],
        'saldo' => $userInfo['saldo']
    ]);
} else {
    echo json_encode([
        'nombre' => 'Invitado',
        'saldo' => '0'
    ]);
}
?>
