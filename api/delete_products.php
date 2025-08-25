<?php
header('Content-Type: application/json');
require_once '../db.php';

$response = ['success' => false, 'message' => ''];

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? 0;

if($id){
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { 
        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $response['success'] = true;
        } else {
            $response['message'] = "Error al eliminar producto: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = "Método no permitido";
    }
} else {
    $response['message'] = "ID no válido";
}

$conn->close();
echo json_encode($response);
?>
