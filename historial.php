<?php
session_start();

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once 'controler/conexion.php';

// Obtener historial de compras
$stmt_compras = $pdo->query("
    SELECT hc.*, u.nombre_usuario 
    FROM historial_compras hc
    JOIN usuarios u ON hc.usuario_id = u.id
    ORDER BY hc.fecha DESC 
    LIMIT 50
");
$compras = $stmt_compras->fetchAll();

// Obtener historial de horneados
$stmt_horneados = $pdo->query("
    SELECT hh.*, u.nombre_usuario 
    FROM historial_horneados hh
    JOIN usuarios u ON hh.usuario_id = u.id
    ORDER BY hh.fecha DESC 
    LIMIT 50
");
$horneados = $stmt_horneados->fetchAll();

// Obtener estadísticas
$stmt_stats = $pdo->query("
    SELECT 
        SUM(monedas_gastadas) as total_monedas,
        SUM(total_horneados) as total_horneados
    FROM progreso_juego
");
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

        /* 🔥 TITULO */
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* 📊 STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #ff6b6b, #ff9a9e);
            color: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
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

        /* 📦 SECCIONES */
        .history-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 1.4em;
            margin-bottom: 20px;
            color: #444;
            border-left: 5px solid #ff6b6b;
            padding-left: 12px;
        }

        /* 📋 TABLAS */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 15px;
        }

        .history-table th {
            background: #ff6b6b;
            color: white;
            padding: 12px;
        }

        .history-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .history-table tr {
            transition: 0.2s;
        }

        .history-table tr:hover {
            background: #fff0f0;
        }

        /* 🏷 BADGE */
        .badge-new {
            background: #4caf50;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.75em;
        }

        /* 😢 EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #888;
        }

        .empty-state div {
            margin-bottom: 10px;
        }

        /* 🔘 BOTONES */
        .buy-btn {
            margin-top: 15px;
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: 0.3s;
        }

        .buy-btn:hover {
            background: #ff4d4d;
        }

        /* 📱 RESPONSIVE */
        @media (max-width: 768px) {
            .history-table {
                font-size: 0.85em;
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
                            <th>Usuario</th>
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
                                <td><?php echo htmlspecialchars($compra['nombre_usuario']); ?></td>

                                <td><?php echo date('d/m/Y H:i', strtotime($compra['fecha'])); ?></td>

                                <td>🧾</td>

                                <td><?php echo htmlspecialchars($compra['item_nombre']); ?></td>

                                <td>x1</td>

                                <td>$<?php echo number_format($compra['precio']); ?></td>

                                <td>$<?php echo number_format($compra['precio']); ?></td>
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
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Postre</th>
                            <th>Ingredientes</th>
                            <th>Recompensa</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($horneados as $horneado): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($horneado['nombre_usuario']); ?></td>

                                <td><?php echo date('d/m/Y H:i', strtotime($horneado['fecha'])); ?></td>

                                <td>🍰 <?php echo htmlspecialchars($horneado['receta_nombre']); ?></td>

                                <td>No disponible</td> <!-- no tienes ingredientes -->

                                <td>+$<?php echo number_format($horneado['recompensa']); ?></td>

                                <td></td> <!-- no tienes es_nueva -->
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