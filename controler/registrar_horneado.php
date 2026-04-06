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
$receta_id = $data['receta_id'];
$receta_nombre = $data['receta_nombre'];
$recompensa = $data['recompensa'];
$fecha = $data['fecha'] ?? date('Y-m-d H:i:s');

$stmt = $pdo->prepare("INSERT INTO historial_horneados (usuario_id, receta_id, receta_nombre, recompensa, fecha) VALUES (?, ?, ?, ?, ?)");
$resultado = $stmt->execute([$usuario_id, $receta_id, $receta_nombre, $recompensa, $fecha]);

echo json_encode(['success' => $resultado]);
?>