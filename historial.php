<?php
session_start();
require_once 'controler/conexion.php';

// Verificar si está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener historial de compras
$stmt_compras = $pdo->prepare("SELECT * FROM historial_compras WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 50");
$stmt_compras->execute([$usuario_id]);
$compras = $stmt_compras->fetchAll();

// Obtener historial de horneados
$stmt_horneados = $pdo->prepare("SELECT * FROM historial_horneados WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 50");
$stmt_horneados->execute([$usuario_id]);
$horneados = $stmt_horneados->fetchAll();

// Obtener estadísticas
$stmt_stats = $pdo->prepare("SELECT monedas_gastadas, total_horneados FROM progreso_juego WHERE usuario_id = ?");
$stmt_stats->execute([$usuario_id]);
$stats = $stmt_stats->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/style.css">
    <title>Mi Historial - Sweet Bakery</title>
    <style>
        .history-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
        }
        .stat-label {
            font-size: 0.9em;
            opacity: 0.9;
            margin-top: 10px;
        }
        .history-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .section-title {
            font-size: 1.5em;
            margin-bottom: 20px;
            color: #333;
            border-left: 4px solid #ff6b6b;
            padding-left: 15px;
        }
        .history-table {
            width: 100%;
            border-collapse: collapse;
        }
        .history-table th,
        .history-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .history-table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #555;
        }
        .history-table tr:hover {
            background: #f8f9fa;
        }
        .badge-new {
            background: #4caf50;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75em;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .icon-cell {
            font-size: 1.5em;
        }
        @media (max-width: 768px) {
            .history-table {
                font-size: 0.85em;
            }
            .history-table th,
            .history-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <?php require_once 'menu.php'; ?>
    
    <div class="history-container">
        <h1>📜 Mi Historial</h1>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($stats['monedas_gastadas'] ?? 0); ?></div>
                <div class="stat-label">💰 Monedas Gastadas</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo number_format($stats['total_horneados'] ?? 0); ?></div>
                <div class="stat-label">🍰 Postres Horneados</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo count($compras); ?></div>
                <div class="stat-label">🛒 Compras Realizadas</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo count($horneados); ?></div>
                <div class="stat-label">🔥 Horneados Registrados</div>
            </div>
        </div>
        
        <div class="history-section">
            <h2 class="section-title">🛍️ Historial de Compras</h2>
            
            <?php if (count($compras) > 0): ?>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Item</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($compras as $compra): ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($compra['fecha'])); ?></td>
                                <td class="icon-cell"><?php echo $compra['item_icono']; ?></td>
                                <td><?php echo htmlspecialchars($compra['item_nombre']); ?></td>
                                <td>x<?php echo $compra['cantidad']; ?></td>
                                <td>$<?php echo number_format($compra['precio']); ?></td>
                                <td>$<?php echo number_format($compra['precio'] * $compra['cantidad']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div style="font-size: 3em;">🛒</div>
                    <p>Aún no has realizado compras</p>
                    <button class="buy-btn" onclick="window.location.href='tienda.php'">Ir a la Tienda</button>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="history-section">
            <h2 class="section-title">🔥 Historial de Horneados</h2>
            
            <?php if (count($horneados) > 0): ?>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Postre</th>
                            <th>Ingredientes</th>
                            <th>Recompensa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($horneados as $horneado): 
                            $ingredientes = json_decode($horneado['ingredientes_usados'], true);
                        ?>
                            <tr>
                                <td><?php echo date('d/m/Y H:i', strtotime($horneado['fecha'])); ?></td>
                                <td class="icon-cell"><?php echo $horneado['receta_icono']; ?> <?php echo htmlspecialchars($horneado['receta_nombre']); ?></td>
                                <td><?php echo implode(', ', $ingredientes); ?></td>
                                <td>+$<?php echo number_format($horneado['recompensa']); ?></td>
                                <td><?php echo $horneado['es_nueva'] ? '<span class="badge-new">✨ Nueva receta!</span>' : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <div style="font-size: 3em;">🔥</div>
                    <p>Aún no has horneado nada</p>
                    <button class="buy-btn" onclick="window.location.href='cocina.php'">Ir a la Cocina</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>