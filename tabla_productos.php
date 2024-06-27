<?php
include 'conexion_bd.php'; 

session_start();

if (!isset($_SESSION['usuario']) && !isset($_COOKIE['usuario'])) {
    header('Location: index.html');
    exit();
}

// Cerrar sesión
if (isset($_GET['cerrar_sesion'])) {
    $_SESSION = array();
    
    session_unset();
    session_destroy();
    
    if (isset($_COOKIE['usuario'])) {
        setcookie('usuario', '', time() - 3600, '/');
    }
    
    if (isset($_COOKIE['administrador'])) {
        setcookie('administrador', '', time() - 3600, '/');
    }
    
    header('Location: index.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si es una solicitud para agregar un nuevo registro
    if (isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['catalogo']) && isset($_POST['cantidad']) && isset($_POST['precio']) && !isset($_POST['id'])) {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $catalogo = $_POST['catalogo'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        $sql = "INSERT INTO productos (Titulo, Descripcion, Catalogo, Cantidad, Precio) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdd", $titulo, $descripcion, $catalogo, $cantidad, $precio);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        exit();
    }
    // Verificar si es una solicitud para actualizar un registro existente
    elseif (isset($_POST['id']) && isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['catalogo']) && isset($_POST['cantidad']) && isset($_POST['precio'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $catalogo = $_POST['catalogo'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];

        $sql = "UPDATE productos SET Titulo=?, Descripcion=?, Catalogo=?, Cantidad=?, Precio=? WHERE ID_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssddi", $titulo, $descripcion, $catalogo, $cantidad, $precio, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        exit();
    }
    // Verificar si es una solicitud para eliminar un registro
    elseif (isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM productos WHERE ID_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        exit();
    }
}

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            $row['ID_producto'],
            $row['Titulo'],
            $row['Descripcion'],
            $row['Catalogo'],
            $row['Cantidad'],
            $row['Precio'],
            '<div class="desplegable">' .
            '<button onclick="btn_acciones(this)">...</button>' .
            '<div class="contenido-desplegable">' .
            '<button onclick="btn_ver()">Ver</button>' .
            '<button onclick="btn_editar()">Editar</button>' .
            '<button onclick="btn_eliminar(' . $row['ID_producto'] . ')">Eliminar</button>' .
            '</div>' .
            '</div>'
        );
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .contenido-desplegable {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .contenido-desplegable button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }
        .contenido-desplegable button:hover {background-color: #f1f1f1;}
        .mostrar {display: block;}
    </style>
</head>
<body>
    <header class="bg-light p-3 mb-4 d-flex justify-content-between align-items-center">
        <nav class="encabezado-centrado">
            <a class="mx-2" href="?cerrar_sesion=1" id="cerrar-sesion">Cerrar Sesión</a>
            <a class="mx-2" href="inicio_admin.php">Inicio Admin</a>
        </nav>
    </header>

    <div class="container mt-5">
        <table id="miTabla" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Catálogo</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo $cell; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal para agregar -->
        <div id="miModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioAgregar">
                            <div class="form-group">
                                <label for="titulo">Título:</label>
                                <input type="text" class="form-control" id="titulo" name="titulo">
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion">
                            </div>
                            <div class="form-group">
                                <label for="catalogo">Catálogo:</label>
                                <select class="form-control" id="catalogo" name="catalogo">
                                    <option value="Bebidas">Bebidas</option>
                                    <option value="Complementos">Complementos</option>
                                    <option value="Momentos Dulces">Momentos Dulces</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad:</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio:</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio">
                            </div>
                            <button type="button" class="btn btn-primary" id="guardarBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar -->
        <div id="modalEditar" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioEditar">
                            <input type="hidden" id="editarId" name="editarId">
                            <div class="form-group">
                                <label for="editarTitulo">Título:</label>
                                <input type="text" class="form-control" id="editarTitulo" name="editarTitulo">
                            </div>
                            <div class="form-group">
                                <label for="editarDescripcion">Descripción:</label>
                                <input type="text" class="form-control" id="editarDescripcion" name="editarDescripcion">
                            </div>
                            <div class="form-group">
                                <label for="editarCatalogo">Catálogo:</label>
                                <select class="form-control" id="editarCatalogo" name="editarCatalogo">
                                <option value="Bebidas">Bebidas</option>
                                <option value="Complementos">Complementos</option>
                                <option value="Momentos Dulces">Momentos Dulces</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editarCantidad">Cantidad:</label>
                                <input type="number" class="form-control" id="editarCantidad" name="editarCantidad">
                            </div>
                            <div class="form-group">
                                <label for="editarPrecio">Precio:</label>
                                <input type="number" step="0.01" class="form-control" id="editarPrecio" name="editarPrecio">
                            </div>
                            <button type="button" class="btn btn-primary" id="actualizarBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button id="agregarBtn" class="btn btn-success mt-3">Agregar Nuevo Producto</button>
    </div>

    <script>
        $(document).ready(function() {
            var tabla = $('#miTabla').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });

            var modal = $('#miModal');
            var modalEditar = $('#modalEditar');
            var btn = $('#agregarBtn');
            var guardarBtn = $('#guardarBtn');
            var actualizarBtn = $('#actualizarBtn');

            // Mostrar el modal para agregar un nuevo registro
            btn.on('click', function() {
                modal.modal('show');
            });

            // Cerrar los modales al hacer clic en el botón de cerrar
            $('.close').on('click', function() {
                modal.modal('hide');
                modalEditar.modal('hide');
            });

            // Guardar nuevo registro
            guardarBtn.on('click', function() {
                var titulo = $('#titulo').val();
                var descripcion = $('#descripcion').val();
                var catalogo = $('#editarCatalogo').val();
                var cantidad = $('#cantidad').val();
                var precio = $('#precio').val();

                if (!titulo || !descripcion || !catalogo || !cantidad || !precio) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Todos los campos son requeridos.'
                    });
                    return;
                }

                if (cantidad < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La cantidad no puede ser negativa.'
                    });
                    return;
                }

                if (precio < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El precio no puede ser negativo.'
                    });
                    return;
                }

                if (cantidad > 20) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: 'La cantidad máxima por producto es 20.'
                    });
                    return;
                }

                if (precio > 100) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: 'El precio máximo es 100.'
                    });
                    return;
                }

                $.post('tabla_productos.php', {
                    titulo: titulo,
                    descripcion: descripcion,
                    catalogo: catalogo,
                    cantidad: cantidad,
                    precio: precio
                }, function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Producto agregado correctamente.'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al agregar el producto: ' + data.error
                    });
                    }
                });
            });

            // Manejar clics en los botones de la tabla
            $('#miTabla tbody').on('click', 'button', function () {
                var accion = $(this).text();
                var data = tabla.row($(this).parents('tr')).data();

                if (accion === 'Ver') {
                    btn_ver(data);
                } else if (accion === 'Editar') {
                    btn_editar(data);
                } else if (accion === 'Eliminar') {
                    var id = data[0];
                    btn_eliminar(id);
                }
            });

            // Actualizar un registro existente
            actualizarBtn.on('click', function() {
                var id = $('#editarId').val();
                var titulo = $('#editarTitulo').val();
                var descripcion = $('#editarDescripcion').val();
                var catalogo = $('#editarCatalogo').val();
                var cantidad = $('#editarCantidad').val();
                var precio = $('#editarPrecio').val();

                if (!titulo || !descripcion || !catalogo || !cantidad || !precio) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Todos los campos son requeridos.'
                    });
                    return;
                }

                if (cantidad < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La cantidad no puede ser negativa.'
                    });
                    return;
                }

                if (precio < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El precio no puede ser negativo.'
                    });
                    return;
                }

                if (cantidad > 20) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: 'La cantidad máxima por producto es 20.'
                    });
                    return;
                }

                if (precio > 100) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Advertencia',
                        text: 'El precio máximo es 100.'
                    });
                    return;
                }

                $.post('tabla_productos.php', {
                    id: id,
                    titulo: titulo,
                    descripcion: descripcion,
                    catalogo: catalogo,
                    cantidad: cantidad,
                    precio: precio
                }, function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'Producto actualizado correctamente.'
                        }).then(() => {
                            location.reload();
                        });
                    }   else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al actualizar el producto: ' + data.error
                                });
                            }
                            });

                            modalEditar.modal('hide');
                        });
                    });

        // Mostrar/ocultar el contenido del dropdown
        function btn_acciones(boton) {
            var contenidoDesplegable = boton.nextElementSibling;
            var dropdowns = document.getElementsByClassName("contenido-desplegable");
            for (var i = 0; i < dropdowns.length; i++) {
                if (dropdowns[i] != contenidoDesplegable) {
                    dropdowns[i].classList.remove('mostrar');
                }
            }
            contenidoDesplegable.classList.toggle("mostrar");
        }

        // Mostrar una alerta con los datos del registro
        function btn_ver(data) {
            Swal.fire({
                title: 'Detalles del Producto',
                html: `
                    <p><strong>ID:</strong> ${data[0]}</p>
                    <p><strong>Título:</strong> ${data[1]}</p>
                    <p><strong>Descripción:</strong> ${data[2]}</p>
                    <p><strong>Categoría:</strong> ${data[3]}</p>
                    <p><strong>Cantidad:</strong> ${data[4]}</p>
                    <p><strong>Precio:</strong> ${data[5]}</p>
                `,
                showCloseButton: true,
                showConfirmButton: false
            });
            cerrarDropdowns();
        }


        // Mostrar el modal de edición con los datos del registro
        function btn_editar(data) {
            $('#editarId').val(data[0]);
            $('#editarTitulo').val(data[1]);
            $('#editarDescripcion').val(data[2]);
            $('#editarCatalogo').val(data[3]);
            $('#editarCantidad').val(data[4]);
            $('#editarPrecio').val(data[5]);
            $('#modalEditar').modal('show');
            cerrarDropdowns();
        }

        // Eliminar un registro
        function btn_eliminar(id) {
            Swal.fire({
                title: "Confirmación",
                text: "¿Estás seguro de eliminar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('tabla_productos.php', { id: id }, function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + data.error);
                        }
                    });
                }
            });
            
            cerrarDropdowns();
        }

        // Cerrar todos los dropdowns
        function cerrarDropdowns() {
            var dropdowns = document.getElementsByClassName("contenido-desplegable");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.remove('mostrar');
            }
        }
    </script>
</body>
</html>
