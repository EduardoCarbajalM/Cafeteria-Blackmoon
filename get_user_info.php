<?php
session_start();
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
