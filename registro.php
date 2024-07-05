<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: inicio.php');
    exit();
}

if (isset($_SESSION['administrador'])) {
    header('Location: inicio_admin.php');
    exit();
}

if (isset($_COOKIE['usuario'])) {
    header('Location: inicio.php');
    exit();
}

if (isset($_COOKIE['administrador'])) {
    header('Location: inicio_admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro</title>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-image: url('img/fondo.jpg');
    background-size: 100% 100%;
    font-family: 'Arial', sans-serif;
}
table {
    margin: 0 auto;
    background-color: rgba(126, 126, 126, 0.48);
    border: 2px solid #333;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(63, 63, 63, 0.1);
    overflow: hidden;
}
td {
    padding: 5px;
}
td:last-child {
    border-bottom: none;
}
h1 {
    margin: 0;
    font-size: 23px;
    color: #ffffff;
}
label {
    font-weight: bold;
    color: #ffffff;
    display: inline-block;
    width: 200px; 
    text-align: right;
    margin-right: 5px; 
}
input[type="text"], input[type="password"], input[type="email"] {
    width: 87%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
input[type="checkbox"] {
    margin-right: 5px;
}
button {
    background-color: #30e3ff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}
button:hover {
    background-color:  #08ffc1;
}
.contenedor-contraseña {
    display: flex;
    align-items: center;
}
.contenedor-contraseña input[type="password"],
.contenedor-contraseña input[type="text"] {
    flex: 1;
}
.alternar-contraseña {
    cursor: pointer;
    margin-left: 5px;
}
.alternar-contraseña img {
    width: 24px;
    height: 24px;
}
.error {
    color: red;
    display: none;
}
</style>
</head>
<body>
    <form id="registroForm" action="agregar_usuario.php" method="post" onsubmit="return validarFormulario()">
        <table>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <h1>Registro</h1>
                </td>
            </tr>
            <tr>
                <td><label for="correo">Correo Electrónico:</label></td>
                <td><input type="email" id="correo" name="correo" maxlength="30" required></td>
            </tr>
            <tr>
                <td><label for="usuario">Usuario:</label></td>
                <td><input type="text" id="usuario" name="usuario" maxlength="10" required></td>
            </tr>
            <tr>
                <td><label for="contraseña">Escoge una contraseña:</label></td>
                <td>
                    <div class="contenedor-contraseña">
                        <input type="password" id="contraseña" name="contraseña" maxlength="20" required>
                        <span class="alternar-contraseña" onclick="alternarContraseña()">
                            <img id="iconoAlternar" src="img/001-visibilidad.png" alt="Mostrar contraseña">
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="confirmar_contraseña">Vuelve a ingresar la contraseña:</label></td>
                <td>
                    <div class="contenedor-contraseña">
                        <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" maxlength="20" required>
                        <span class="alternar-contraseña" onclick="alternarContraseñaConfirmacion()">
                            <img id="iconoAlternarConfirmacion" src="img/001-visibilidad.png" alt="Mostrar contraseña">
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button id="btn_enviar" type="submit">Registrarme</button>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <p>¿Ya tienes una cuenta? <a href="index.php">Ingresa aquí</a></p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <p class="error" id="errorContraseña">Las contraseñas no coinciden.</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <p class="error" id="errorContraseñaEspacios">La contraseña no puede contener espacios en blanco.</p>
                </td>
            </tr>
        </table>
    </form>

    <script>
        function alternarContraseña() {
            const entradaContraseña = document.getElementById('contraseña');
            const iconoAlternar = document.getElementById('iconoAlternar');
            if (entradaContraseña.type === 'password') {
                entradaContraseña.type = 'text';
                iconoAlternar.src = 'img/002-ojo.png';
                iconoAlternar.alt = 'Ocultar contraseña';
            } else {
                entradaContraseña.type = 'password';
                iconoAlternar.src = 'img/001-visibilidad.png';
                iconoAlternar.alt = 'Mostrar contraseña';
            }
        }

        function alternarContraseñaConfirmacion() {
            const entradaContraseña = document.getElementById('confirmar_contraseña');
            const iconoAlternar = document.getElementById('iconoAlternarConfirmacion');
            if (entradaContraseña.type === 'password') {
                entradaContraseña.type = 'text';
                iconoAlternar.src = 'img/002-ojo.png';
                iconoAlternar.alt = 'Ocultar contraseña';
            } else {
                entradaContraseña.type = 'password';
                iconoAlternar.src = 'img/001-visibilidad.png';
                iconoAlternar.alt = 'Mostrar contraseña';
            }
        }

        function validarFormulario() {
            const contraseña = document.getElementById('contraseña').value;
            const confirmarContraseña = document.getElementById('confirmar_contraseña').value;
            const errorContraseña = document.getElementById('errorContraseña');
            const errorContraseñaEspacios = document.getElementById('errorContraseñaEspacios');


            // Sanitizar la entrada del usuario
            const usuario = document.getElementById('usuario').value.trim();
            const correo = document.getElementById('correo').value.trim();

            // Verificar si el usuario o el correo están vacíos
            if (usuario === '' || correo === '') {
                swal('Error', 'El nombre de usuario y el correo electrónico son obligatorios.', 'error');
                return false;
            }

            // Verificar si el nombre de usuario contiene caracteres especiales o números
            const regexUsuario = /^[a-zA-Z]+$/;
            if (!regexUsuario.test(usuario)) {
                swal('Error', 'El nombre de usuario solo puede contener letras.', 'error');
                return false;
            }

            // Verificar si las contraseñas coinciden
            if (contraseña !== confirmarContraseña) {
                errorContraseña.style.display = 'block';
                swal('Error', 'Las contraseñas no coinciden.', 'error');
                return false;
            } else {
                errorContraseña.style.display = 'none';
            }
          
            // Verificar si la contraseña contiene espacios en blanco
            if (/\s/.test(contraseña)) {
                errorContraseñaEspacios.style.display = 'block';
                swal('Error', 'La contraseña no puede contener espacios en blanco.', 'error');
                return false;
            } else {
                errorContraseñaEspacios.style.display = 'none';
            }
          
            return true;
        }
    </script>
    <script>
        document.onkeydown = function(e) {
            if ((e.ctrlKey && 
                (e.keyCode === 85 || // Ctrl+U
                e.keyCode === 117)) || // Ctrl+F6
                (e.ctrlKey && e.shiftKey && e.keyCode === 73) || // Ctrl+Shift+I
                e.keyCode === 123) { // F12
                return false;
            }
        };

        document.oncontextmenu = function(e) {
    		e.preventDefault();
        };
    </script>
</body>
</html>
