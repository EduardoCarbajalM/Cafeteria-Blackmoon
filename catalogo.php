<?php
include 'conexion_bd.php';

if (!isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['usuario'])) {
        // Si existe una cookie, reiniciar la sesión
        $_SESSION['usuario'] = $_COOKIE['usuario'];
    } else {
        header('Location: index.html');
        exit();
    }
}

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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: antiquewhite;
        }
        table {
            margin: 0 auto;
            background-color: white;
            border: 2px solid black;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
        }
        button {
            background-color: lightblue;
        }
        .top-container {
            margin-bottom: 10px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
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
            width: 100%;
            background: none;
            border: none;
            text-align: left;
        }
        .dropdown-content button:hover {
            background-color: #f1f1f1;
        }
        .show {
            display: block;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <button id="addRowBtn">Agregar Nuevo Campo</button>
    
    <table id="myTable">
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
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar Nuevo Campo</h2>
            <form id="addRowForm">
                <label for="id">ID:</label><br>
                <input type="text" id="id" name="id"><br>
                <label for="name">Nombre:</label><br>
                <input type="text" id="name" name="name"><br>
                <label for="password">Contraseña:</label><br>
                <input type="text" id="password" name="password"><br>
                <label for="email">Correo:</label><br>
                <input type="text" id="email" name="email"><br><br>
                <input type="button" id="saveRowBtn" value="Guardar">
            </form>
        </div>
    </div>

    <!-- Scripts de JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var tabla = $('#myTable').DataTable();

            var modal = document.getElementById("myModal");
            var btn = document.getElementById("addRowBtn");
            var span = document.getElementsByClassName("close")[0];
            var guardarBtn = document.getElementById("saveRowBtn");

            btn.onclick = function() {
                modal.style.display = "block";
            }

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(evento) {
                if (evento.target == modal) {
                    modal.style.display = "none";
                }
            }

            guardarBtn.onclick = function() {
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

                modal.style.display = "none";
                $('#addRowForm')[0].reset();
            }
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
            alert('Ver');
            cerrarDropdowns();
        }

        function btn_editar() {
            alert('Editar');
            cerrarDropdowns();
        }

        function btn_eliminar() {
            alert('Eliminar');
            cerrarDropdowns();
        }

        function cerrarDropdowns() {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                dropdowns[i].classList.remove('show');
            }
        }

        window.onclick = function(evento) {
            if (!evento.target.matches('.dropdown button')) {
                cerrarDropdowns();
            }
        }
    </script>
</body>
</html>
