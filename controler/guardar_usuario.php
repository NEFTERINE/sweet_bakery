<?php
require_once 'conexion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_usuario = trim($_POST['nombre_usuario']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $confirmar = $_POST['confirmar_contrasena'];

    // 🔽 CAPTCHA (AHORA BIEN UBICADO) 🔽
    $captcha = $_POST['g-recaptcha-response'] ?? '';

    if (empty($captcha)) {
        $error = 'Verifica el captcha';
    } else {
        $secret = '6LfvHVcsAAAAAKXEQPymxgIbfi79MwslUznI74MZ'; // SOLO UNO

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $secret,
            'response' => $captcha
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $respuesta = json_decode($response, true);

        if (!$respuesta['success']) {
            $error = 'Captcha no válido';
        }
    }
    // 🔼 FIN CAPTCHA 🔼

    // 👇 SOLO SI TODO VA BIEN
    if (empty($error)) {

        if (empty($nombre_usuario) || empty($correo) || empty($contrasena)) {
            $error = 'Todos los campos son obligatorios';
        } elseif ($contrasena !== $confirmar) {
            $error = 'Las contraseñas no coinciden';
        } elseif (strlen($contrasena) < 6) {
            $error = 'La contraseña debe tener al menos 6 caracteres';
        } else {

            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? OR correo = ?");
            $stmt->execute([$nombre_usuario, $correo]);

            if ($stmt->fetch()) {
                $error = 'El nombre de usuario o correo ya está registrado';
            } else {

                $hash = password_hash($contrasena, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("
                    INSERT INTO usuarios (nombre_usuario, correo, contraseña) 
                    VALUES (?, ?, ?)
                ");

                if ($stmt->execute([$nombre_usuario, $correo, $hash])) {

                    $usuario_id = $pdo->lastInsertId();

                    $inventario_inicial = json_encode([]);
                    $recetas_inicial = json_encode([]);

                    $stmt2 = $pdo->prepare("
                        INSERT INTO progreso_juego 
                        (usuario_id, monedas, inventario, recetas_desbloqueadas, ultima_actualizacion, monedas_gastadas, total_horneados) 
                        VALUES (?, 100, ?, ?, NOW(), 0, 0)
                    ");

                    $stmt2->execute([$usuario_id, $inventario_inicial, $recetas_inicial]);

                    header('Location: ../cocina.php');
                    exit;

                } else {
                    $error = 'Error al registrar usuario. Intenta de nuevo.';
                }
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