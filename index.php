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
<title>Login</title>
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
            background-color: rgba(119, 121, 121, 0.48);
            border: 2px solid #333;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        td {
            padding: 10px 20px;
            
        }
        td:last-child {
            border-bottom: none;    
        }
        h1 {
            margin: 0;
            font-size: 24px;
            color: #f6f1f1;
        }
        label {
            font-weight: bold;
            color: #f5f9fa;
        }
        input[type="text"], input[type="password"] {
            width: 88%;
            padding: 5px;
            border: 1px solid #ccc; 
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            margin-right: 9px;
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
            background-color: #08ffc1;
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
</style>
</head>
<body onload="inicializarPagina()">
    <form action="login.php" method="post">
        <table>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <h1>Login</h1>
                </td>
            </tr>
            <tr>
                <td><label for="usuario">Usuario:</label></td>
                <td><input type="text" id="usuario" name="usuario" required></td>
            </tr>
            <tr>
                <td><label for="contraseña">Contraseña:</label></td>
                <td>
                    <div class="contenedor-contraseña">
                        <input type="password" id="contraseña" name="contraseña" required>
                        <span class="alternar-contraseña" onclick="alternarContraseña()">
                            <img src="img/001-visibilidad.png" alt="Mostrar contraseña" id="iconoAlternar">
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="checkbox" id="recordar" name="recordar"> <label for="recordar">Recuérdame</label>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button id="btn_enviar" type="submit">Entrar</button>
                    <p>No tienes una cuenta? <a href="registro.php">Registrate aquí</a></p>
                </td>
            </tr>
        </table>
    </form>

    <script>
        function inicializarPagina() {
            const iconoAlternar = document.getElementById('iconoAlternar');
            iconoAlternar.src = 'img/001-visibilidad.png';
            iconoAlternar.alt = 'Mostrar contraseña';
        }

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

      <?php
      if (isset($_SESSION['error'])) {
        echo "swal('Error', '{$_SESSION['error']}', 'error');";
        unset($_SESSION['error']);
      }
      ?>
    </script>
</body>
</html>
