<?php
include 'conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conn->real_escape_string($_POST['usuario']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $correo = $conn->real_escape_string($_POST['correo']);

    // Verificar si el nombre de usuario o el correo electrónico ya existen
    $sql_verificar = "SELECT * FROM usuarios WHERE Nombre = '$nombre' OR Correo = '$correo'";
    $result = $conn->query($sql_verificar);

    if ($result->num_rows > 0) {
        echo "El nombre de usuario o el correo electrónico ya están registrados.";
    } else {
        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (Nombre, Contraseña, Correo) VALUES ('$nombre', '$contraseña', '$correo')";

        if ($conn->query($sql) === TRUE) {
            echo "Nuevo usuario registrado exitosamente";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <a href="index.html">Iniciar Sesion</a>
</body>
</html>