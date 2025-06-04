<?php
require 'backend.php';

$data = json_decode(file_get_contents('php://input'), true);

$conn = getDBConnection();

// Encriptar datos sensibles
$dni_encrypted = encryptData($data['dni']);
$historial_encrypted = encryptData($data['historial_medico']);

$stmt = $conn->prepare("INSERT INTO estudiantes (nombre, apellido, fecha_nacimiento, dni_encrypted, historial_medico_encrypted) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", 
    $data['nombre'],
    $data['apellido'],
    $data['fecha_nacimiento'],
    $dni_encrypted,
    $historial_encrypted
);

$response = ['success' => false];
if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['message'] = $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>