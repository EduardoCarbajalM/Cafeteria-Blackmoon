<?php
ini_set("display_errors", E_ALL);
include 'conexion_bd.php';

session_start();

// Verificar si no hay cookie ni sesión de usuario activa
if (!isset($_COOKIE['usuario']) && !isset($_SESSION['usuario'])) {
    header('Location: index.html');
    exit();
}

// Inicializar los arreglos
$bebidas = [];
$complementos = [];
$momentos_dulces = [];

// Consulta para obtener los productos
$query = "SELECT Titulo, Descripcion, Precio, Catalogo, Cantidad FROM productos";
$result = $conn->query($query);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto = [
            'titulo' => $row['Titulo'],
            'descripcion' => $row['Descripcion'],
            'precio' => $row['Precio'],
            'categoria' => strtolower(str_replace(' ', '-', $row['Catalogo'])),
            'imagen' => '',
            'stock' => $row['Cantidad']
        ];

        // Añadir la ruta de la imagen manualmente según el título del producto
        switch ($row['Titulo']) {
            case 'Expreso':
                $producto['imagen'] = 'img/expreso.jpg';
                break;
            case 'Capuchino':
                $producto['imagen'] = 'img/capuchino.jpg';
                break;
            case 'Tisana de moras':
                $producto['imagen'] = 'img/tisana.jpeg';
                break;
            case 'Frappé':
                $producto['imagen'] = 'img/frappe.jpeg';
                break;
            case 'Baguette':
                $producto['imagen'] = 'img/bp.jpg';
                break;
            case 'Ensalada Cesar':
                $producto['imagen'] = 'img/ec.jpeg';
                break;
            case 'Pasta Alfredo':
                $producto['imagen'] = 'img/pf.jpeg';
                break;
            case 'Tarta de Chocolate':
                $producto['imagen'] = 'img/pastelc.jpg';
                break;
            case 'Pastel de mocha':
                $producto['imagen'] = 'img/pastelMoka.jpeg';
                break;
            case 'Flan':
                $producto['imagen'] = 'img/flan.jpg';
                break;
            case 'Pay de limón':
                $producto['imagen'] = 'img/paylimon.jpeg';
                break;
            default:
                $producto['imagen'] = 'img/default.jpg';
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="minimenu.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <style>
        .mx-2{
            color: saddlebrown;
            font-family: 'medieval', cursive;
            font-size: medium;
            text-decoration: solid;
        }
        .mx-2 il{
            color: saddlebrown;
            font-family: 'medieval', cursive;
        }
        body{
            background-color: #FAEBD7;       
            font-family: 'medieval', cursive;
        }
        .text-center{
            font-family: 'medieval', cursive;
        }
        .lead::before{
        content: "★" ;
        }
        footer{
            text-align: center;
            padding:40px;

        }
        #horario-overlay h1 {
            font-family: 'medieval', cursive;
            color: saddlebrown;
        }
    </style>
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
        <img src="img/carrito.png" alt="Carrito de Compras" id="carrito-icono" style="cursor: pointer;">
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
                                    <?php if ($bebida['stock'] > 0): ?>
                                        <button class="btn btn-primary btn-agregar-carrito"
                                            onclick="agregarAlCarrito('<?= $bebida['titulo'] ?>', '<?= $bebida['descripcion'] ?>', <?= $bebida['precio'] ?>, '<?= $bebida['imagen'] ?>', <?= $bebida['stock'] ?>)">+</button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled>Producto agotado</button>
                                    <?php endif; ?>
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
                                <?php if ($complemento['stock'] > 0): ?>
                                    <button class="btn btn-primary btn-agregar-carrito"
                                        onclick="agregarAlCarrito('<?= $complemento['titulo'] ?>', '<?= $complemento['descripcion'] ?>', <?= $complemento['precio'] ?>, '<?= $complemento['imagen'] ?>', <?= $complemento['stock'] ?>)">+</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>Producto agotado</button>
                                <?php endif; ?>
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
                    <?php foreach ($momentos_dulces as $momento_dulce): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= $momento_dulce['imagen'] ?>" class="card-img-top" alt="Producto">
                            <div class="card-body">
                                <h5 class="card-title"><?= $momento_dulce['titulo'] ?></h5>
                                <p class="card-text"><?= $momento_dulce['descripcion'] ?></p>
                                <p class="card-text"><small class="text-muted">Precio: $<?= number_format($momento_dulce['precio'], 2) ?></small></p>
                                <?php if ($momento_dulce['stock'] > 0): ?>
                                    <button class="btn btn-primary btn-agregar-carrito"
                                        onclick="agregarAlCarrito('<?= $momento_dulce['titulo'] ?>', '<?= $momento_dulce['descripcion'] ?>', <?= $momento_dulce['precio'] ?>, '<?= $momento_dulce['imagen'] ?>', <?= $momento_dulce['stock'] ?>)">+</button>
                                <?php else: ?>
                                    <button class="btn btn-secondary" disabled>Producto agotado</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

        <!-- Carrito de Compras -->
        <div id="carrito-compras">
            <h5>Carrito de Compras</h5>
            <div id="carrito-items"></div>
            <div class="d-flex justify-content-between mt-3">
                <strong>Total:</strong>
                <span id="total-carrito">$0.00</span>
            </div>
            <div class="row mt-4">
                <div class="col-6 text-center">
                    <button class="btn btn-secondary btn-block" onclick="cancelarOrden()">Cancelar Orden</button>
                </div>
                <div class="col-6 text-center">
                    <form id="orden-form" method="post" action="orden.php" style="display: none;">
                        <input type="hidden" name="carrito" id="carrito-input">
                    </form>
                    <button class="btn btn-primary btn-block" onclick="confirmarOrden()">Confirmar Orden</button>
                </div>
            </div>
        </div>

        <!-- Botón de scroll-top -->
        <button id="btn-scroll-top"><i class="fas fa-arrow-up"></i></button>
    </div>

    <script>
        // Arreglo para almacenar los productos del carrito
        let carrito = [];

        // Función para agregar un producto al carrito
        function agregarAlCarrito(titulo, descripcion, precio, imagen, stock) {
            const producto = carrito.find(item => item.titulo === titulo);
            if (producto) {
                if (producto.cantidad < stock && producto.cantidad < 5) {
                    producto.cantidad++;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No puedes agregar más unidades de este producto.',
                    });
                }
            } else {
                if (stock > 0) {
                    carrito.push({ titulo, descripcion, precio, imagen, cantidad: 1, stock });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Producto agotado',
                        text: 'Este producto está agotado.',
                    });
                }
            }
            actualizarCarrito();
        }



        // Función para actualizar la vista del carrito
        function actualizarCarrito() {
            const carritoItems = document.getElementById('carrito-items');
            const totalCarrito = document.getElementById('total-carrito');
            const carritoCompras = document.getElementById('carrito-compras');
            const botonesCarrito = document.querySelectorAll('#carrito-compras .row');

            carritoItems.innerHTML = '';

            let total = 0;

            if (carrito.length === 0) {
                carritoItems.innerHTML = '<p>Tu carrito se encuentra vacío, agrega productos para realizar un pedido</p>';
                totalCarrito.innerText = '$0.00';

                // Ocultar el total y los botones
                totalCarrito.parentElement.style.display = 'none'; // Ocultar el total
                botonesCarrito.forEach(boton => boton.style.display = 'none');
            } else {
                carrito.forEach((producto, index) => {
                    total += producto.precio * producto.cantidad;

                    const item = document.createElement('div');
                    item.classList.add('carrito-item');
                    item.innerHTML = `
                        <div class="d-flex align-items-center">
                            <img src="${producto.imagen}" alt="${producto.titulo}">
                            <div class="info">
                                <h6>${producto.titulo}</h6>
                                <p>Precio: $${producto.precio.toFixed(2)}</p>
                                <p>Cantidad: ${producto.cantidad}</p>
                                <p>Subtotal: $${(producto.precio * producto.cantidad).toFixed(2)}</p>
                            </div>
                            <div class="acciones">
                                <button class="btn btn-sm btn-primary" onclick="cambiarCantidad(${index}, 1)">+</button>
                                <button class="btn btn-sm btn-secondary" onclick="cambiarCantidad(${index}, -1)">-</button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarDelCarrito(${index})">Eliminar</button>
                            </div>
                        </div>
                    `;
                    carritoItems.appendChild(item);
                });

                totalCarrito.innerText = `$${total.toFixed(2)}`;

                // Mostrar el total y los botones
                totalCarrito.parentElement.style.display = 'flex'; // Mostrar el total
                botonesCarrito.forEach(boton => boton.style.display = 'flex');
            }
        }


        // Función para cambiar la cantidad de un producto en el carrito
        function cambiarCantidad(index, cantidad) {
            if ((carrito[index].cantidad + cantidad > carrito[index].stock) || (carrito[index].cantidad + cantidad > 5)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No puedes agregar más unidades de este producto.',
                    });
                } else {
                carrito[index].cantidad += cantidad;
                if (carrito[index].cantidad <= 0) {
                    carrito.splice(index, 1);
                }
                actualizarCarrito();
            }
        }



        // Función para eliminar un producto del carrito
        function eliminarDelCarrito(index) {
            carrito.splice(index, 1);
            actualizarCarrito();
        }

        // Función para cancelar la orden
        function cancelarOrden() {
            carrito = [];
            actualizarCarrito();
        }

        // Función para confirmar la orden
        function confirmarOrden() {
            const carritoInput = document.getElementById('carrito-input');
            carritoInput.value = JSON.stringify(carrito);
            document.getElementById('orden-form').submit();
        }

        // Mostrar u ocultar el carrito al hacer clic en el icono del carrito
        document.getElementById('carrito-icono').addEventListener('click', () => {
            const carritoCompras = document.getElementById('carrito-compras');
            carritoCompras.style.display = carritoCompras.style.display === 'none' ? 'block' : 'none';
        });

        // Mostrar el botón de scroll cuando se baja la página
        window.addEventListener('scroll', () => {
            const btnScrollTop = document.getElementById('btn-scroll-top');
            if (window.scrollY > 200) {
                btnScrollTop.style.display = 'block';
            } else {
                btnScrollTop.style.display = 'none';
            }
        });

        // Función para el botón de scroll hacia arriba
        document.getElementById('btn-scroll-top').addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Llamada inicial para actualizar el carrito al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            actualizarCarrito();
        });
    </script>
</body>
<script src="minimenu.js"></script>
<script src="cerrarsesion.js"></script>
</html>