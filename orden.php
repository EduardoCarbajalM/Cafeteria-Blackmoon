<?php
include 'conexion_bd.php';

// Generar un número de ticket aleatorio de máximo 9 números
function generarNumeroTicket() {
    return rand(100000000, 999999999);
}

// Obtener los datos del carrito desde la solicitud POST
$carrito = isset($_POST['carrito']) ? json_decode($_POST['carrito'], true) : [];

// Calcular el número de productos y el total a pagar
$numeroProductos = 0;
$totalPagar = 0;
foreach ($carrito as $producto) {
    $numeroProductos += $producto['cantidad'];
    $totalPagar += $producto['precio'] * $producto['cantidad'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'comprar') {
    // Obtener el nombre del usuario (suponiendo que está almacenado en una variable de sesión)
    session_start();
    $nombreUsuario = $_SESSION['usuario'];

    // Obtener el saldo del usuario
    $query_saldo = "SELECT saldo FROM usuarios WHERE Nombre = ?";
    $stmt_saldo = $conn->prepare($query_saldo);
    $stmt_saldo->bind_param('s', $nombreUsuario);
    $stmt_saldo->execute();
    $stmt_saldo->bind_result($saldo);
    $stmt_saldo->fetch();
    $stmt_saldo->close();

    if ($saldo >= $totalPagar) {
        // Actualizar el saldo del usuario
        $nuevoSaldo = $saldo - $totalPagar;
        $update_saldo_query = "UPDATE usuarios SET saldo = ? WHERE Nombre = ?";
        $update_saldo_stmt = $conn->prepare($update_saldo_query);
        $update_saldo_stmt->bind_param('is', $nuevoSaldo, $nombreUsuario);
        $update_saldo_stmt->execute();
        $update_saldo_stmt->close();

        foreach ($carrito as $producto) {
            $titulo = $producto['titulo'];
            $cantidad = $producto['cantidad'];

            // Obtener la cantidad actual del producto
            $query = "SELECT Cantidad FROM productos WHERE Titulo = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $titulo);
            $stmt->execute();
            $stmt->bind_result($cantidad_actual);
            $stmt->fetch();
            $stmt->close();

            if ($cantidad_actual >= $cantidad) {
                // Reducir la cantidad de productos en la base de datos
                $nueva_cantidad = $cantidad_actual - $cantidad;
                $update_query = "UPDATE productos SET Cantidad = ? WHERE Titulo = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param('is', $nueva_cantidad, $titulo);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                // Manejar el caso en que no haya suficiente stock
                echo "<script>alert('No hay suficiente stock para el producto: $titulo'); window.location.href = 'orden.php';</script>";
                exit;
            }
        }
        // Cerrar la conexión
        $conn->close();

        echo '<script>alert("Compra realizada con éxito!"); window.location.href = "inicio.html";</script>';
        exit;
    } else {
        echo '<script>alert("Saldo insuficiente para realizar la compra."); window.location.href = "menu.php";</script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Orden</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Ticket de Orden</h2>
            </div>
            <div class="card-body">
                <p><strong>No. de Ticket:</strong> <?= generarNumeroTicket() ?></p>
                <p><strong>No. de Productos:</strong> <?= $numeroProductos ?></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrito as $producto): ?>
                        <tr>
                            <td><?= $producto['titulo'] ?></td>
                            <td><img src="<?= $producto['imagen'] ?>" alt="<?= $producto['titulo'] ?>" style="width: 50px;"></td>
                            <td>$<?= number_format($producto['precio'], 2) ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td>$<?= number_format($producto['precio'] * $producto['cantidad'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="text-right"><strong>Total a Pagar:</strong> $<?= number_format($totalPagar, 2) ?></p>
                <form method="post">
                    <input type="hidden" name="carrito" value='<?= json_encode($carrito) ?>'>
                    <input type="hidden" name="accion" value="comprar">
                    <button id="btn-comprar" class="btn btn-success">Comprar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
