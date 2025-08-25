<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../db.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if ($id == '') {
        $response['message'] = "ID del producto es obligatorio";
        echo json_encode($response);
        exit;
    }

    // Traer los datos actuales del producto
    $stmt = $conn->prepare("SELECT nombre, precio, imagen FROM productos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombreActual, $precioActual, $imagenActual);
    $stmt->fetch();
    $stmt->close();

    // Tomar los valores nuevos si vienen, si no usar los actuales
    $nombre = isset($_POST['nombre']) && $_POST['nombre'] !== '' ? $_POST['nombre'] : $nombreActual;
    $precio = isset($_POST['precio']) && $_POST['precio'] !== '' ? $_POST['precio'] : $precioActual;
    $imagen = $imagenActual;

    // Procesar imagen nueva si se envió
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $img_name = time() . '_' . basename($_FILES['imagen']['name']);
        $target_dir = '../uploads/';
        $target_file = $target_dir . $img_name;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            $imagen = $img_name; // reemplaza solo si hay imagen nueva
        }
    }

    // Actualizar el producto con los valores (viejos o nuevos)
    $stmt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, imagen=? WHERE id=?");
    $stmt->bind_param("sdsi", $nombre, $precio, $imagen, $id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Producto modificado correctamente";
    } else {
        $response['message'] = "Error al modificar producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['message'] = "Método no permitido";
}

$conn->close();
echo json_encode($response);
