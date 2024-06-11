<?php
include 'conexion_bd.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            $row['ID'],
            $row['Nombre'],
            $row['Contraseña'],
            $row['Correo'],
            '<div class="dropdown">' .
            '<button onclick="btn_acciones(this)">...</button>' .
            '<div class="dropdown-content">' .
            '<button onclick="btn_ver()">Ver</button>' .
            '<button onclick="btn_editar()">Editar</button>' .
            '<button onclick="btn_eliminar()">Eliminar</button>' .
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
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }
        .dropdown-content button:hover {background-color: #f1f1f1;}
        .show {display: block;}
    </style>
</head>
<body>
    <div class="container mt-5">
        <table id="myTable" class="display">
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

        <!-- Modal -->
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Campo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addRowForm">
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" id="id" name="id">
                            </div>
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="text" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="email">Correo:</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <button type="button" class="btn btn-primary" id="saveRowBtn">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button id="addRowBtn" class="btn btn-success mt-3">Agregar Nuevo Campo</button>
    </div>

    <!-- Scripts de JavaScript -->
    <script>
        $(document).ready(function() {
            var tabla = $('#myTable').DataTable();

            var modal = $('#myModal');
            var btn = $('#addRowBtn');
            var guardarBtn = $('#saveRowBtn');

            btn.on('click', function() {
                modal.modal('show');
            });

            $('.close').on('click', function() {
                modal.modal('hide');
            });

            $(window).on('click', function(event) {
                if ($(event.target).is(modal)) {
                    modal.modal('hide');
                }
            });

            guardarBtn.on('click', function() {
                var id = $('#id').val();
                var nombre = $('#name').val();
                var contraseña = $('#password').val();
                var correo = $('#email').val();

                tabla.row.add([
                    id,
                    nombre,
                    contraseña,
                    correo,
                    '<div class="dropdown">' +
                    '<button onclick="btn_acciones(this)">...</button>' +
                    '<div class="dropdown-content">' +
                    '<button onclick="btn_ver()">Ver</button>' +
                    '<button onclick="btn_editar()">Editar</button>' +
                    '<button onclick="btn_eliminar()">Eliminar</button>' +
                    '</div>' +
                    '</div>'
                ]).draw(false);

                modal.modal('hide');
                $('#addRowForm')[0].reset();
            });

            $('#myTable tbody').on('click', 'button', function () {
                var action = $(this).text();
                var data = tabla.row($(this).parents('tr')).data();

                if (action === 'Ver') {
                    btn_ver(data);
                } else if (action === 'Editar') {
                    btn_editar(data);
                } else if (action === 'Eliminar') {
                    btn_eliminar(data);
                }
            });
        });

        function btn_acciones(boton) {
            var contenidoDropdown = boton.nextElementSibling;
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                if (dropdowns[i] != contenidoDropdown) {
                    dropdowns[i].classList.remove('show');
                }
            }
            contenidoDropdown.classList.toggle("show");
        }

        function btn_ver() {
            Swal.fire('Ver');
            cerrarDropdowns();
        }

        function btn_editar() {
            Swal.fire('Editar');
            cerrarDropdowns();
        }

        function btn_eliminar() {
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
                    Swal.fire({
                        title: "Eliminado",
                        text: "Eliminación exitosa",
                        icon: "success"
                    });
                }
            });
            
            cerrarDropdowns();
        }

        function cerrarDropdowns() {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.remove('show');
            }
        }
    </script>
</body>
</html>
