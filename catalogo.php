<?php
include 'conexion_bd.php'; // Incluir el archivo de conexión a la base de datos

// Manejar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si es una solicitud para agregar un nuevo registro
    if (isset($_POST['nombre']) && isset($_POST['contraseña']) && isset($_POST['correo']) && !isset($_POST['id'])) {
        $nombre = $_POST['nombre'];
        $contraseña = $_POST['contraseña'];
        $correo = $_POST['correo'];

        $sql = "INSERT INTO usuarios (Nombre, Contraseña, Correo) VALUES ('$nombre', '$contraseña', '$correo')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit();
    } 
    // Verificar si es una solicitud para actualizar un registro existente
    elseif (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['contraseña']) && isset($_POST['correo'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $contraseña = $_POST['contraseña'];
        $correo = $_POST['correo'];

        $sql = "UPDATE usuarios SET Nombre='$nombre', Contraseña='$contraseña', Correo='$correo' WHERE ID=$id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit();
    } 
    // Verificar si es una solicitud para eliminar un registro
    elseif (isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM usuarios WHERE ID = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        exit();
    }
}

// Obtener todos los registros de la tabla de usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

$data = array();

// Crear un array con los datos obtenidos
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            $row['ID'],
            $row['Nombre'],
            $row['Contraseña'],
            $row['Correo'],
            '<div class="desplegable">' .
            '<button onclick="btn_acciones(this)">...</button>' .
            '<div class="contenido-desplegable">' .
            '<button onclick="btn_ver()">Ver</button>' .
            '<button onclick="btn_editar()">Editar</button>' .
            '<button onclick="btn_eliminar(' . $row['ID'] . ')">Eliminar</button>' .
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
    <title>Catálogo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        <table id="miTabla" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Correo</th>
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
                        <h5 class="modal-title">Agregar Nuevo Campo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioAgregar">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                            <div class="form-group">
                                <label for="contraseña">Contraseña:</label>
                                <input type="text" class="form-control" id="contraseña" name="contraseña">
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo:</label>
                                <input type="text" class="form-control" id="correo" name="correo">
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
                        <h5 class="modal-title">Editar Campo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioEditar">
                            <input type="hidden" id="editarId" name="editarId">
                            <div class="form-group">
                                <label for="editarNombre">Nombre:</label>
                                <input type="text" class="form-control" id="editarNombre" name="editarNombre">
                            </div>
                            <div class="form-group">
                                <label for="editarContraseña">Contraseña:</label>
                                <input type="text" class="form-control" id="editarContraseña" name="editarContraseña">
                            </div>
                            <div class="form-group">
                                <label for="editarCorreo">Correo:</label>
                                <input type="text" class="form-control" id="editarCorreo" name="editarCorreo">
                            </div>
                            <button type="button" class="btn btn-primary" id="actualizarBtn">Actualizar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button id="agregarBtn" class="btn btn-success mt-3">Agregar Nuevo Campo</button>
    </div>

    <!-- Scripts de JavaScript -->
    <script>
        $(document).ready(function() {
            var tabla = $('#miTabla').DataTable();

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
                var nombre = $('#nombre').val();
                var contraseña = $('#contraseña').val();
                var correo = $('#correo').val();

                $.post('catalogo.php', {
                    nombre: nombre,
                    contraseña: contraseña,
                    correo: correo
                }, function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
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
                var nombre = $('#editarNombre').val();
                var contraseña = $('#editarContraseña').val();
                var correo = $('#editarCorreo').val();

                $.post('catalogo.php', {
                    id: id,
                    nombre: nombre,
                    contraseña: contraseña,
                    correo: correo
                }, function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.error);
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
            Swal.fire('Ver: ' + JSON.stringify(data));
            cerrarDropdowns();
        }

        // Mostrar el modal de edición con los datos del registro
        function btn_editar(data) {
            $('#editarId').val(data[0]);
            $('#editarNombre').val(data[1]);
            $('#editarContraseña').val(data[2]);
            $('#editarCorreo').val(data[3]);
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
                confirmButtonText: "Aceptar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('catalogo.php', { id: id }, function(response) {
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
