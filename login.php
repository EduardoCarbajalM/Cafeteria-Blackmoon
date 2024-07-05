<?php
ini_set("display_errors", E_ALL);
session_start();
include 'conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $contraseña = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_STRING);
    $recordar = isset($_POST['recordar']);

    if (!$usuario || !$contraseña) {
        echo "<script>alert('Datos de entrada inválidos.'); window.location.href = 'index.php';</script>";
        exit();
    }

    // Usar una declaración preparada para evitar inyecciones SQL
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE Nombre = ? AND Password = ?");
    $sql->bind_param("ss", $usuario, $contraseña);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($recordar) {
            // Crear una cookie que expire en 5 minutos
            if ($row['Administrador'] == 1) {
                setcookie("administrador", $usuario, time() + (5 * 60), "/");
                // Debug
                error_log("Cookie administrador creada para usuario: $usuario");
            } else {
                setcookie("usuario", $usuario, time() + (5 * 60), "/");
                // Debug
                error_log("Cookie usuario creada para usuario: $usuario");
            }
        } else {
            // Iniciar una sesión normal
            if ($row['Administrador'] == 1) {
                $_SESSION['administrador'] = $usuario;
                // Debug
                error_log("Sesión administrador iniciada para usuario: $usuario");
            } else {
                $_SESSION['usuario'] = $usuario;
                // Debug
                error_log("Sesión usuario iniciada para usuario: $usuario");
            }
        }

        // Verificar si el usuario es un administrador
        if ($row['Administrador'] == 1) {
            // Redirigir a inicio_admin.php
            header('Location: inicio_admin.php');
        } else {
            // Redirigir a inicio.php
            header('Location: inicio.php');
        }
        exit();
    } else {
        // Usuario o contraseña incorrectos
        $_SESSION['error'] = 'Usuario o contraseña inválidos';
        header('Location: index.php');
        exit();
    }

    $conn->close();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    // Eliminar las cookies
    setcookie("usuario", "", time() - 3600, "/");
    setcookie("administrador", "", time() - 3600, "/");
    header('Location: index.php');
    exit();
}
?>
