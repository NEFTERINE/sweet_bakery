<?php

session_start();

require_once 'conexion.php';
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
require_once 'conexion.php';

$usuario_id = $_SESSION['usuario_id'];
$item_id = $data['item_id'];
$item_nombre = $data['item_nombre'];
$precio = $data['precio'];
$fecha = $data['fecha'] ?? date('Y-m-d H:i:s');

$stmt = $pdo->prepare("INSERT INTO historial_compras (usuario_id, item_id, item_nombre, precio, fecha) VALUES (?, ?, ?, ?, ?)");
$resultado = $stmt->execute([$usuario_id, $item_id, $item_nombre, $precio, $fecha]);

echo json_encode(['success' => $resultado]);
?>