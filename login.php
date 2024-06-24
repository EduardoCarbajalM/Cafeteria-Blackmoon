<?php
session_start();
include 'conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $contraseña = $conn->real_escape_string($_POST['contraseña']);
    $recordar = isset($_POST['recordar']);

    // Consultar usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE Nombre = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash = $row['Contraseña'];

        // Verificar si la contraseña ingresada coincide con el hash almacenado
        if (password_verify($contraseña, $hash)) {
            if ($recordar) {
                // Crear una cookie que expire en 5 minutos
                setcookie("usuario", $usuario, time() + (5 * 60), "/");
            } else {
                // Iniciar una sesión normal
                $_SESSION['usuario'] = $usuario;
            }
            header('Location: inicio.html');
            exit();
        } else {
            // Contraseña incorrecta
            header('Location: error.php');
            exit();
        }
    } else {
        // Usuario no encontrado
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
    header('Location: index.html');
    exit();
}
?>
