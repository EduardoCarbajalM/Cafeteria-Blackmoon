<?php
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    session_unset();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h1>Credenciales incorrectas</h1>
    <h2>Usuario/contraseña inválidos</h2>
    <a href="index.html">Regresar</a>
</body>
</html>
