<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion_bd.php';

// Consulta para obtener productos por categoría
try {
    // Consulta para bebidas
    $consultaBebidas = "SELECT * FROM productos WHERE categoria = 'Bebidas'";
    $resultBebidas = $conn->query($consultaBebidas);
    $bebidas = [];

    if ($resultBebidas->num_rows > 0) {
        while ($row = $resultBebidas->fetch_assoc()) {
            $bebidas[] = $row;
        }
    }

    // Consulta para complementos
    $consultaComplementos = "SELECT * FROM productos WHERE categoria = 'Complementos'";
    $resultComplementos = $conn->query($consultaComplementos);
    $complementos = [];

    if ($resultComplementos->num_rows > 0) {
        while ($row = $resultComplementos->fetch_assoc()) {
            $complementos[] = $row;
        }
    }

    // Consulta para momentos dulces
    $consultaMomentosDulces = "SELECT * FROM productos WHERE categoria = 'Momentos Dulces'";
    $resultMomentosDulces = $conn->query($consultaMomentosDulces);
    $momentosDulces = [];

    if ($resultMomentosDulces->num_rows > 0) {
        while ($row = $resultMomentosDulces->fetch_assoc()) {
            $momentosDulces[] = $row;
        }
    }

    // Crear un array asociativo con los resultados
    $resultado = array(
        'bebidas' => $bebidas,
        'complementos' => $complementos,
        'momentosDulces' => $momentosDulces
    );

    // Devolver como JSON
    echo json_encode($resultado);
} catch (Exception $e) {
    die("Error al obtener productos: " . $e->getMessage());
}

// Cerrar conexión a la base de datos
$conn->close();
?>
