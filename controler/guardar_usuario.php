<?php
require_once 'conexion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar_contrasena'];
    
    // Validaciones
    if (empty($nombre_usuario) || empty($correo) || empty($contrasena)) {
        $error = 'Todos los campos son obligatorios';
    } elseif ($contrasena !== $confirmar) {
        $error = 'Las contraseñas no coinciden';
    } elseif (strlen($contrasena) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } else {
        // Verificar si el usuario o correo ya existen
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
        $stmt->execute([$nombre_usuario, $correo]);
        
        if ($stmt->fetch()) {
            $error = 'El nombre de usuario o correo ya está registrado';
        } else {
            // Crear usuario
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, correo, contraseña) VALUES (?, ?, ?)");
            
            if ($stmt->execute([$nombre_usuario, $correo, $hash])) {
                $usuario_id = $pdo->lastInsertId();
                
                // Crear progreso inicial del juego
                $inventario_inicial = json_encode([]);
                $recetas_inicial = json_encode([]);
                $stmt2 = $pdo->prepare("INSERT INTO progreso_juego (usuario_id, monedas, inventario, recetas_desbloqueadas, monedas_gastadas, total_horneados) VALUES (?, 100, ?, ?, 0, 0)");
                $stmt2->execute([$usuario_id, $inventario_inicial, $recetas_inicial]);
                
                $success = 'Registro exitoso. ¡Ya puedes iniciar sesión!';
                header('Location: ../cocina.php');
                exit;
            } else {
                $error = 'Error al registrar usuario. Intenta de nuevo.';
            }
        }
    }
}

if ($error) {
    session_start();
    $_SESSION['error_registro'] = $error;
    header('Location: ../formulario_usuario.php');
    exit;
}
?>