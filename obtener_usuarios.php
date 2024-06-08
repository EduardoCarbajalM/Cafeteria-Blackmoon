<?php
include 'conexion_bd.php';

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

$usuarios = array();
while($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

$conn->close();

echo json_encode($usuarios);
?>
