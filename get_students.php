<?php
require 'backend.php';

$conn = getDBConnection();

$result = $conn->query("SELECT id, nombre, apellido, fecha_nacimiento, dni_encrypted, historial_medico_encrypted FROM estudiantes");
$students = [];

while ($row = $result->fetch_assoc()) {
    // Desencriptar datos sensibles
    $students[] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'apellido' => $row['apellido'],
        'fecha_nacimiento' => $row['fecha_nacimiento'],
        'dni' => decryptData($row['dni_encrypted']),
        'historial_medico' => $row['historial_medico_encrypted'] ? decryptData($row['historial_medico_encrypted']) : null
    ];
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($students);
?>