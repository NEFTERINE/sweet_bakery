<?php
session_start();

// Mostrar mensajes de sesión
$error = $_SESSION['error_registro'] ?? '';
$success = $_SESSION['registro_exitoso'] ?? '';

// Limpiar mensajes de sesión
unset($_SESSION['error_registro']);
unset($_SESSION['registro_exitoso']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Sweet Bakery</title>
    <link rel="stylesheet" href="Css/style.css">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
        }
        .btn-auth {
            width: 100%;
            padding: 12px;
            background: #ff6b6b;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-auth:hover {
            background: #ff5252;
        }
        .error {
            background: #ffe0e0;
            color: #d32f2f;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            background: #e0ffe0;
            color: #2e7d32;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: center;
        }
        .link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php require_once 'menu.php'; ?>
    
    <div class="auth-container">
        <h2>🍰 Registro de Usuario</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form action="controler/guardar_usuario.php" method="POST">
            <div class="form-group">
                <label>Nombre de Usuario</label>
                <input type="text" name="nombre_usuario" required>
            </div>
            
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" required>
            </div>
            
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="confirmar_contrasena" required>
            </div>
            
            <button type="submit" class="btn-auth">Registrarse</button>
        </form>
        
        <div class="link">
            ¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a>
        </div>
    </div>
</body>
</html>