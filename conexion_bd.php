<?php
ini_set("display_errors", E_ALL);
$server = "localhost";
$user = "root";
$pass = "Root";
$bd = "programacionweb";

$conn = new mysqli($server, $user, $pass, $bd);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
Conexion en hosting
ini_set("display_errors",E_ALL);
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
*/
?>
