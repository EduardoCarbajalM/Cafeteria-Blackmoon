<?php
session_start();

// Verificar si hay una sesión o una cookie activa
if (isset($_SESSION['usuario']) || isset($_COOKIE['usuario'])) {
    header("Location: bienvenido.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarios = [
        'Eduardo' => 'hol@',
        'Erick' => '@dios',
        'Sara' => 'sudo'
    ];

    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $recordar = isset($_POST['recordar']);

    if (array_key_exists($usuario, $usuarios) && $usuarios[$usuario] === $contraseña) {
        if ($recordar) {
            // Crear una cookie que expire en 5 minutos
            setcookie("usuario", $usuario, time() + (5 * 60), "/");
        } else {
            // Iniciar una sesión normal
            $_SESSION['usuario'] = $usuario;
        }
        header('Location: bienvenido.php');
        exit();
    } else {
        header('Location: error.php');
        exit();
    }
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
