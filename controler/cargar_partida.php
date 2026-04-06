<?php
session_start();
header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No has iniciado sesión']);
    exit;
}

// Conectar a la base de datos
require_once 'conexion.php';

$usuario_id = $_SESSION['usuario_id'];

// Buscar el progreso del usuario
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
        'success' => false,
        'error' => 'No hay partida guardada'
    ]);
}
?>