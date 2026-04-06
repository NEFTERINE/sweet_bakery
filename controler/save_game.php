<?php
require_once 'conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$usuario_id = $_SESSION['usuario_id'];

$monedas = $data['coins'] ?? 100;
$inventario = json_encode($data['inventory'] ?? []);
$recetas = json_encode($data['createdDesserts'] ?? []);
$monedas_gastadas = $data['monedas_gastadas'] ?? 0;
$total_horneados = $data['total_horneados'] ?? 0;

$stmt = $pdo->prepare("UPDATE progreso_juego SET monedas = ?, inventario = ?, recetas_desbloqueadas = ?, monedas_gastadas = ?, total_horneados = ? WHERE usuario_id = ?");
$stmt->execute([$monedas, $inventario, $recetas, $monedas_gastadas, $total_horneados, $usuario_id]);

echo json_encode(['success' => true]);
?>