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
    <title>Descripción</title>
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
        <h1 class="text-center">Bienvenidos a BLACKMOON</h1>
        <p class="lead">Donde la pasión por la excelencia y la dedicación a la calidad se encuentran en cada aspecto de nuestra operación. Somos un establecimiento dedicado a ofrecer una experiencia gastronómica única, combinando el mejor café con un ambiente acogedor y un servicio excepcional.</p>
        <p class="lead">BLACKMOON fue fundado con la visión de crear un lugar donde la comunidad pueda disfrutar de una buena charla y un café excepcional en un ambiente acogedor y elegante. Desde nuestros humildes comienzos, nos hemos esforzado por mantener los más altos estándares en la preparación de nuestras bebidas y postres, utilizando ingredientes frescos y de la más alta calidad.</p>
        <p class="lead">En BLACKMOON, creemos que una buena bebida debe ser una experiencia memorable. Nos esforzamos por crear sabores que no solo satisfagan el paladar, sino que también cuenten una historia. Nuestra filosofía se basa en la combinación de tradición e innovación, creando un menú que celebra tanto los sabores clásicos del café como los contemporáneos.</p>
        <p class="lead">Nuestro equipo está compuesto por profesionales apasionados por la gastronomía. Desde nuestros bartenders hasta nuestro personal de servicio, todos en BLACKMOON comparten un compromiso con la excelencia y la satisfacción del cliente. Creemos que nuestro éxito se debe a nuestro equipo dedicado que trabaja incansablemente para brindar la mejor experiencia posible a nuestros clientes.</p>
        <p class="lead">La calidad es la piedra angular de BLACKMOON. Nos aseguramos de que cada taza que servimos esté preparada con los mejores ingredientes y técnicas culinarias. Además, mantenemos un entorno limpio y seguro para nuestros clientes y empleados, cumpliendo con todas las normativas sanitarias y de seguridad.</p>
        <p class="lead">Nuestra misión es ser el destino preferido para aquellos que buscan una experiencia y un buen sabor excepcional. Nos esforzamos por superar las expectativas de nuestros clientes en cada visita, creando recuerdos duraderos a través de nuestros sabores y servicio.</p>
        <p class="lead">Nos encontramos en Av. Té 950, Granjas México, Iztacalco, 08400 Ciudad de México, CDMX, un lugar estratégico y accesible para todos. Te invitamos a visitarnos y descubrir por ti mismo la experiencia BLACKMOON.</p>
        <!-- Mapa de Google -->
        <div class="mapa">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3763.3822350152927!2d-99.0918475!3d19.395884!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1fc2e3efc321b%3A0xabf8454acb3a3a99!2sUPIICSA%20%E2%80%93%20Unidad%20Profesional%20Interdisciplinaria%20de%20Ingenier%C3%ADa%20y%20Ciencias%20Sociales%20y%20Administrativas%20IPN!5e0!3m2!1ses-419!2smx!4v1719279130473!5m2!1ses-419!2smx" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
    <footer>
        <p class="copyright">&copy Copyright BLACKMOON - 2024</p>
    </footer>
</body>
<script src="minimenu.js"></script>
<script src="cerrarsesion.js"></script>
</html>