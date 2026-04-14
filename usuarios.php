<?php
require_once 'controler/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: login.php');
    exit;
}


$stmt = $pdo->query("SELECT id, nombre_usuario, correo, tipo, estatus FROM usuarios");
$usuarios = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/style.css">

    <title>Document</title>
</head>

<body>
    <?php require_once 'menu.php'; ?>

    <style>
        .user-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .user-table th {
            background: #ff6b6b;
            color: white;
            padding: 12px;
        }

        .user-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .user-table tr:hover {
            background: #fff0f0;
        }

        /* badges */
        .badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: white;
            font-size: 0.8em;
        }

        .admin {
            background: #6c5ce7;
        }

        .user {
            background: #00b894;
        }

        .activo {
            background: #4caf50;
        }

        .inactivo {
            background: #d63031;
        }

        a {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 10px;
            margin-right: 5px;
            font-size: 0.9em;
        }

        a[href*="cambiar_estado"] {
            background: #0984e3;
            color: white;
        }

        a[href*="eliminar_usuario"] {
            background: #d63031;
            color: white;
        }

        .admin-container {
            max-width: 1000px;
            margin: 40px auto;
            /* centra horizontal */
            text-align: center;
        }

        /* centra la tabla pero mantiene texto interno alineado */
        .user-table {
            margin: 0 auto;
            text-align: left;
        }
    </style>

    <div class="admin-container">

        <h1>👥 Administración de Usuarios</h1>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($usuarios as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['nombre_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($user['correo']); ?></td>

                        <td>
                            <span class="badge <?php echo $user['tipo'] === 'admin' ? 'admin' : 'user'; ?>">
                                <?php echo $user['tipo']; ?>
                            </span>
                        </td>

                        <td>
                            <span class="badge <?php echo $user['estatus'] === 'activo' ? 'activo' : 'inactivo'; ?>">
                                <?php echo $user['estatus']; ?>
                            </span>
                        </td>

                        <td>
                            <a href="controler/cambiar_estado.php?id=<?php echo $user['id']; ?>">
                                🔄 Estado
                            </a>

                            <?php if ($user['id'] != $_SESSION['usuario_id']): ?>
                                <a href="controler/eliminar_usuario.php?id=<?php echo $user['id']; ?>"
                                    onclick="return confirm('¿Eliminar usuario?')">
                                    🗑 Eliminar
                                </a>
                            <?php else: ?>
                                <span style="color: gray;">(Tú)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>