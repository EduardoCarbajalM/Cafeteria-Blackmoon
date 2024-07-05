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

if (count(get_included_files()) == 1) {
    header("Location: ?cerrar_sesion=1");
    exit();
}

ini_set("display_errors", E_ALL);
$servername = "db5016009403.hosting-data.io"; // Nombre de host
$port = "3306"; // Puerto
$username = "dbu4369946"; // Nombre de usuario de la base de datos
$password = "ipn.2023600613"; // Contraseña de la base de datos
$dbname = "dbs13045012"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
