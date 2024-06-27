<?php
ini_set("display_errors", E_ALL);
require_once 'conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['usuario'];
    $password = $_POST['contraseña'];
    $correo = $_POST['correo'];

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
            echo "<script>alert('REGISTRADO CORRECTAMENTE $nombre'); window.location.href = 'index.html';</script>";
        } else {
            echo "Error: " . $sql->error;
        }
    }

    $conn->close();
}
?>
