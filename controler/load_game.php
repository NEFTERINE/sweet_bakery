<?php
require_once 'conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT monedas, inventario, recetas_desbloqueadas FROM progreso_juego WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$progreso = $stmt->fetch();

if ($progreso) {
    echo json_encode([
        'success' => true,
        'coins' => $progreso['monedas'],
        'inventory' => json_decode($progreso['inventario'], true) ?: [],
        'createdDesserts' => json_decode($progreso['recetas_desbloqueadas'], true) ?: []
    ]);
} else {
    echo json_encode([
        'success' => true,
        'coins' => 100,
        'inventory' => [],
        'createdDesserts' => []
    ]);
}
?>