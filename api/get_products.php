<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../db.php';

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT id, nombre, precio, imagen FROM productos");

    if ($result) {
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        $response['success'] = true;
        $response['data'] = $productos;
    } else {
        $response['message'] = "Error al obtener productos: " . $conn->error;
    }
} else {
    $response['message'] = "Método no permitido";
}

$conn->close();
echo json_encode($response);
?>
