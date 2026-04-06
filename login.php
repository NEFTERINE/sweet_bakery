<?php

session_start();
require_once 'controler/conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contrasena = $_POST['contrasena'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
    $stmt->execute([$nombre_usuario, $nombre_usuario]);
    $usuario = $stmt->fetch();
    
    if ($usuario && password_verify($contrasena, $usuario['contraseña'])) {
        if ($usuario['estatus'] !== 'activo') {
            $error = 'Tu cuenta está ' . $usuario['estatus'];
        } else {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre_usuario'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            
            // Actualizar último login
            $update = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?");
            $update->execute([$usuario['id']]);
            
            header('Location: cocina.php');
            exit;
        }
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sweet Bakery</title>
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
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
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
        <h2>🍰 Iniciar Sesión</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Usuario o Correo</label>
                <input type="text" name="nombre_usuario" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" required>
            </div>
            
            <button type="submit" class="btn-auth">Ingresar</button>
        </form>
        
        <div class="link">
            ¿No tienes cuenta? <a href="formulario_usuario.php">Regístrate</a>
        </div>
    </div>
</body>
</html>