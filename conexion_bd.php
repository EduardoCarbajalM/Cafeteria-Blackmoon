<?php
/*
FORMA DEL PROFESOR

ini_set("display_errors",E_ALL);
//Conectar a la base de datos 
$server = "localhost";
$user = "root";
$pass = "Root";
$bd = "programacionweb";
$cnx = mysqli_connect($server,$user,$pass,$bd)
or die("Error en la conexion MySQL");

if(mysqli_connect_errno()) {
    printf("Connect failed: %s\n", 
    mysqli_connect_error());
    exit();
}
echo "Conexion exitosa"; */
ini_set("display_errors", E_ALL);
$server = "localhost";
$user = "root";
$pass = "Root";
$bd = "programacionweb";

$conn = new mysqli($server, $user, $pass, $bd);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Conexion exitosa";
//echo "<br>";
?>
