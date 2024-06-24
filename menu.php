<?php
include 'conexion_bd.php';

// Inicializar los arreglos
$bebidas = [];
$complementos = [];
$momentos_dulces = [];

// Consulta para obtener los productos
$query = "SELECT Titulo, Descripcion, Precio, Catalogo FROM productos";
$result = $conn->query($query);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $producto = [
            'titulo' => $row['Titulo'],
            'descripcion' => $row['Descripcion'],
            'precio' => $row['Precio'],
            'categoria' => strtolower(str_replace(' ', '-', $row['Catalogo'])),
            'imagen' => '' // Dejar vacío para añadir la ruta manualmente
        ];
        
        // Añadir la ruta de la imagen manualmente según el título del producto
        switch ($row['Titulo']) {
            case 'Café Latte':
                $producto['imagen'] = 'img/helado.jpg';
                break;
            case 'Pepsi':
                $producto['imagen'] = 'imagenes/pepsi.jpg';
                break;
            case 'Agua Mineral':
                $producto['imagen'] = 'imagenes/agua_mineral.jpg';
                break;
            // Añadir más casos según sea necesario
            default:
                $producto['imagen'] = 'imagenes/default.jpg'; // Imagen por defecto si no se encuentra una específica
        }

        // Clasificar los productos según su categoría
        switch ($row['Catalogo']) {
            case 'Bebidas':
                $bebidas[] = $producto;
                break;
            case 'Complementos':
                $complementos[] = $producto;
                break;
            case 'Momentos Dulces':
                $momentos_dulces[] = $producto;
                break;
        }
    }
} else {
    echo "No hay productos disponibles";
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menus</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <style>
        /* Estilos adicionales para el botón de scroll */
        #btn-scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none; /* Ocultar inicialmente el botón */
            z-index: 1000; /* Asegura que esté sobre otros elementos */
            background-color: #007bff; /* Color de fondo */
            color: #fff; /* Color de texto */
            border: none; /* Sin borde */
            border-radius: 50%; /* Borde redondeado */
            width: 50px; /* Ancho */
            height: 50px; /* Altura */
            text-align: center; /* Alineación del texto */
            line-height: 48px; /* Ajuste vertical para centrar el ícono */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Sombra */
        }

        /* Estilo para el ícono dentro del botón */
        #btn-scroll-top i {
            font-size: 20px; /* Tamaño del ícono */
        }

        /* Estilos para el botón de agregar al carrito */
        .btn-agregar-carrito {
            width: 100%;
            margin-top: 10px;
        }

        /* Estilos para el carrito de compras */
        #carrito-compras {
            max-height: 300px; /* Altura máxima del carrito */
            overflow-y: auto; /* Permitir scroll vertical si el contenido excede el tamaño */
            border: 1px solid #ccc; /* Borde */
            padding: 10px;
            margin-top: 20px;
            display: none; /* Ocultar inicialmente */
            position: absolute;
            background-color: #fff;
            right: 10px;
            top: 60px;
            width: 415px; /* Ancho del menú desplegable */
            z-index: 1000;
        }

        /* Estilos para cada item en el carrito */
        .carrito-item {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .carrito-item img {
            max-width: 50px; /* Tamaño máximo de la imagen */
            margin-right: 10px;
        }

        .carrito-item .info {
            flex-grow: 1;
        }

        .carrito-item .acciones {
            text-align: right;
        }

        .carrito-item .acciones button {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <header class="bg-light p-3 mb-4 d-flex justify-content-between align-items-center">
        <img src="https://via.placeholder.com/50" alt="mini menu usuario" class="rounded-circle">
        <nav>
            <a class="mx-2" href="inicio.html">Inicio</a>
            <a class="mx-2" href="menu.html">Menús</a>
            <a class="mx-2" href="promos.html">Promos</a>
        </nav>
        <!-- Imagen que simulará el carrito de compras -->
        <img src="https://via.placeholder.com/30" alt="Carrito de Compras" id="carrito-icono" style="cursor: pointer;">
    </header>

    <div class="container">
        <div class="row">
            <div class="col">
                <nav class="d-flex justify-content-center mb-4">
                    <ul class="list-unstyled d-flex">
                        <li class="mx-2"><a href="#bebidas">Bebidas</a></li>
                        <li class="mx-2"><a href="#complementos">Complementos</a></li>
                        <li class="mx-2"><a href="#momentos-dulces">Momentos dulces</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <div id="bebidas" class="row">
            <div class="col">
                <h2 class="text-center">Bebidas</h2>
                <div class="row" id="contenedor-bebidas">
                    <?php foreach ($bebidas as $bebida): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= $bebida['imagen'] ?>" class="card-img-top" alt="Producto">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $bebida['titulo'] ?></h5>
                                    <p class="card-text"><?= $bebida['descripcion'] ?></p>
                                    <p class="card-text"><small class="text-muted">Precio: $<?= number_format($bebida['precio'], 2) ?></small></p>
                                    <button class="btn btn-primary btn-agregar-carrito" onclick="agregarAlCarrito('<?= $bebida['titulo'] ?>', '<?= $bebida['descripcion'] ?>', <?= $bebida['precio'] ?>, '<?= $bebida['imagen'] ?>')">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="complementos" class="row">
            <div class="col">
                <h2 class="text-center">Complementos</h2>
                <div class="row" id="contenedor-complementos">
                    <?php foreach ($complementos as $complemento): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= $complemento['imagen'] ?>" class="card-img-top" alt="Producto">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $complemento['titulo'] ?></h5>
                                    <p class="card-text"><?= $complemento['descripcion'] ?></p>
                                    <p class="card-text"><small class="text-muted">Precio: $<?= number_format($complemento['precio'], 2) ?></small></p>
                                    <button class="btn btn-primary btn-agregar-carrito" onclick="agregarAlCarrito('<?= $complemento['titulo'] ?>', '<?= $complemento['descripcion'] ?>', <?= $complemento['precio'] ?>, '<?= $complemento['imagen'] ?>')">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div id="momentos-dulces" class="row">
            <div class="col">
                <h2 class="text-center">Momentos Dulces</h2>
                <div class="row" id="contenedor-momentos-dulces">
                    <?php foreach ($momentos_dulces as $dulce): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?= $dulce['imagen'] ?>" class="card-img-top" alt="Producto">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $dulce['titulo'] ?></h5>
                                    <p class="card-text"><?= $dulce['descripcion'] ?></p>
                                    <p class="card-text"><small class="text-muted">Precio: $<?= number_format($dulce['precio'], 2) ?></small></p>
                                    <button class="btn btn-primary btn-agregar-carrito" onclick="agregarAlCarrito('<?= $dulce['titulo'] ?>', '<?= $dulce['descripcion'] ?>', <?= $dulce['precio'] ?>, '<?= $dulce['imagen'] ?>')">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <button id="btn-scroll-top"><i class="fas fa-arrow-up"></i></button>

        <div id="carrito-compras"></div>
    </div>

    <script>
        document.getElementById('carrito-icono').addEventListener('click', function() {
            var carrito = document.getElementById('carrito-compras');
            if (carrito.style.display === 'none') {
                carrito.style.display = 'block';
            } else {
                carrito.style.display = 'none';
            }
        });

        window.addEventListener('scroll', function() {
            var btnScrollTop = document.getElementById('btn-scroll-top');
            if (window.pageYOffset > 300) {
                btnScrollTop.style.display = 'block';
            } else {
                btnScrollTop.style.display = 'none';
            }
        });

        document.getElementById('btn-scroll-top').addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        function agregarAlCarrito(titulo, descripcion, precio, imagen) {
            var carrito = document.getElementById('carrito-compras');

            var item = document.createElement('div');
            item.className = 'carrito-item d-flex';

            var img = document.createElement('img');
            img.src = imagen;
            img.alt = titulo;

            var info = document.createElement('div');
            info.className = 'info';
            info.innerHTML = '<strong>' + titulo + '</strong><p>' + descripcion + '</p><p><small>$' + precio.toFixed(2) + '</small></p>';

            var acciones = document.createElement('div');
            acciones.className = 'acciones';
            var btnEliminar = document.createElement('button');
            btnEliminar.className = 'btn btn-danger btn-sm';
            btnEliminar.textContent = 'Eliminar';
            btnEliminar.addEventListener('click', function() {
                carrito.removeChild(item);
            });

            acciones.appendChild(btnEliminar);

            item.appendChild(img);
            item.appendChild(info);
            item.appendChild(acciones);

            carrito.appendChild(item);
            carrito.style.display = 'block';
        }
    </script>
</body>
</html>
