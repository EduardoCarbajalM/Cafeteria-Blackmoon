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
$servername = "db5016002676.hosting-data.io"; // Nombre de host
$port = "3306"; // Puerto
$username = "dbu402379"; // Nombre de usuario de la base de datos
$password = "Politecnico.01"; // Contraseña de la base de datos
$dbname = "dbs13040412"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
*/
?>
