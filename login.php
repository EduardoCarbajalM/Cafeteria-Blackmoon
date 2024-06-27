<?php
session_start();
include 'conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $recordar = isset($_POST['recordar']);

    // Usar una declaración preparada para evitar inyecciones SQL
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE Nombre = ? AND Password = ?");
    $sql->bind_param("ss", $usuario, $contraseña);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($recordar) {
            // Crear una cookie que expire en 5 minutos
            setcookie("usuario", $usuario, time() + (5 * 60), "/");
            setcookie("administrador", $row['Administrador'], time() + (5 * 60), "/");
        } else {
            // Iniciar una sesión normal
            $_SESSION['usuario'] = $usuario;
            $_SESSION['administrador'] = $row['Administrador'];
        }

        // Verificar si el usuario es un administrador
        if ($row['Administrador'] == 1) {
            // Redirigir a inicio_admin.html
            header('Location: inicio_admin.php');
        } else {
            // Redirigir a inicio.html
            header('Location: inicio.php');
        }
        exit();
    } else {
        // Usuario o contraseña incorrectos
        header('Location: error.php');
        exit();
    }

    $conn->close();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    // Eliminar la cookie
    setcookie("usuario", "", time() - 3600, "/");
    setcookie("administrador", "", time() - 3600, "/");
    header('Location: index.html');
    exit();
}
?>
