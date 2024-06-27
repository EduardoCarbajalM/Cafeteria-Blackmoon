<?php
session_start();

// Verificar si no hay cookie ni sesión de usuario activa
if (!isset($_COOKIE['usuario']) && !isset($_SESSION['usuario'])) {
    header('Location: index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminos y Condiciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="minimenu.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
</head>
<body>
    <header class="bg-light p-3 mb-4 d-flex justify-content-between align-items-center">
        <img src="img/usuario.png" alt="mini menu usuario" class="rounded-circle">
        <nav>
            <a class="mx-2" href="inicio.php">Inicio</a>
            <a class="mx-2" href="menu.php">Menús</a>
            <a class="mx-2" href="promos.php">Promos</a>
            <a class="mx-2" href="#" id="logout">Cerrar Sesión</a>
        </nav>
    </header>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="container">
        <h1 class="text-center">Términos y condiciones BLACKMOON</h1>
        <p class="lead">Bienvenido a BLACKMOON. Al acceder y utilizar nuestro sitio web, usted acepta cumplir y estar sujeto a los siguientes términos y condiciones. Por favor, lea estos términos cuidadosamente antes de utilizar nuestro servicio.</p>
        <p class="lead">BLACKMOON se compromete a proteger la información personal de los clientes mediante medidas de seguridad adecuadas. La información recopilada se utilizará únicamente para mejorar el servicio y no se compartirá con terceros sin el consentimiento del cliente.</p>
        <p class="lead">Los clientes pueden pagar sus pedidos en línea utilizando el saldo de la tarjeta BLACKMOON. El saldo de la tarjeta BLACKMOON solo puede ser recargado en la sucursal.</p>
        <p class="lead">BLACKMOON no se hace responsable por daños indirectos, incidentales, especiales o consecuentes que resulten del uso del sitio web. BLACKMOON no garantiza que el sitio web esté libre de errores o que siempre esté disponible sin interrupciones.</p>
        <p class="lead">Todo el contenido del sitio web, incluyendo textos, imágenes, logos y software, es propiedad de BLACKMOON y está protegido por leyes de derechos de autor y marcas comerciales. Está prohibido el uso no autorizado de cualquier contenido del sitio web.</p>
        <p class="lead">BLACKMOON se reserva el derecho de modificar estos términos y condiciones en cualquier momento. Las modificaciones serán efectivas inmediatamente después de su publicación en el sitio web. El uso continuo del sitio web constituye la aceptación de los términos modificados.</p>
        <p class="lead">Estos términos y condiciones se regirán e interpretarán de acuerdo con las leyes del país donde se encuentra BLACKMOON. Cualquier disputa relacionada con estos términos será resuelta en los tribunales competentes del país de BLACKMOON.</p>
        <p class="lead">Para cualquier consulta o preocupación sobre estos términos y condiciones, por favor, contacte a BLACKMOON a través de la información de contacto proporcionada en el sitio web.</p>
    </div>
    <footer>
        <p class="copyright">&copy Copyright BLACKMOON - 2024</p>
    </footer>
</body>
<script src="minimenu.js"></script>
<script src="cerrarsesion.js"></script>
</html>