<?php
ini_set("display_errors", E_ALL);
require_once 'conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: registro.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);

    if (!$nombre || !$password || !$correo) {
        echo "<script>alert('Datos de entrada inválidos.'); window.location.href = 'registro.php';</script>";
        exit();
    }

    // Verificar si el nombre de usuario o el correo electrónico ya existen
    $sql_verificar = $conn->prepare("SELECT * FROM usuarios WHERE Nombre = ? OR Correo = ?");
    $sql_verificar->bind_param("ss", $nombre, $correo);
    $sql_verificar->execute();
    $result = $sql_verificar->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('El nombre de usuario o el correo electrónico ya están registrados.'); window.location.href = 'registro.php';</script>";
    } else {
        $saldoInicial = 1000;
        $esAdmin = 0; // Valor falso para el campo Administrador
        $sql = $conn->prepare("INSERT INTO usuarios (Nombre, Password, Correo, saldo, Administrador) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param("sssii", $nombre, $password, $correo, $saldoInicial, $esAdmin);

        if ($sql->execute() === TRUE) {
            echo "<script>alert('REGISTRADO CORRECTAMENTE $nombre'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $sql->error;
        }
    }

    $conn->close();
}
?>
