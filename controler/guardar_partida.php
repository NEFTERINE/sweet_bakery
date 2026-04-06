<?php
header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'No has iniciado sesión']);
    exit;
}

// Recibir los datos del juego
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'No se recibieron datos']);
    exit;
}

// Conectar a la base de datos
require_once 'conexion.php';

$usuario_id = $_SESSION['usuario_id'];
$monedas = $data['coins'];
$inventario = json_encode($data['inventory']);
$recetas = json_encode($data['createdDesserts']);

// Verificar si ya existe un registro para este usuario
$stmt = $pdo->prepare("SELECT id FROM progreso_juego WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$existe = $stmt->fetch();

if ($existe) {
    // Actualizar registro existente
    $stmt = $pdo->prepare("UPDATE progreso_juego SET monedas = ?, inventario = ?, recetas_desbloqueadas = ? WHERE usuario_id = ?");
    $resultado = $stmt->execute([$monedas, $inventario, $recetas, $usuario_id]);
} else {
    // Crear nuevo registro
    $stmt = $pdo->prepare("INSERT INTO progreso_juego (usuario_id, monedas, inventario, recetas_desbloqueadas) VALUES (?, ?, ?, ?)");
    $resultado = $stmt->execute([$usuario_id, $monedas, $inventario, $recetas]);
}

if ($resultado) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al guardar en la base de datos']);
}
?>