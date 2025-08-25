<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../db.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $img_name = time() . '_' . basename($_FILES['imagen']['name']);
        $target_dir = '../uploads/';
        $target_file = $target_dir . $img_name;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            $imagen = $img_name;
        } else {
            $imagen = '';
        }
    } else {
        $imagen = '';
    }

    if ($nombre != '' && $precio != '' && $imagen != '') {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, imagen) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $nombre, $precio, $imagen);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Producto agregado correctamente";
        } else {
            $response['message'] = "Error al agregar producto: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = "Faltan datos obligatorios";
    }

} else {
    $response['message'] = "Método no permitido";
}

$conn->close();
echo json_encode($response);
?>
