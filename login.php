<?php

require_once 'controler/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contrasena = $_POST['contrasena'];

    // 🔽 AQUI VA EL RECAPTCHA 🔽
    $captcha = $_POST['g-recaptcha-response'] ?? '';

    if (empty($captcha)) {
        $error = 'Verifica el captcha';
    } else {
        $secret = '6LfvHVcsAAAAAKXEQPymxgIbfi79MwslUznI74MZ'; // tu clave secreta real

        $verificar = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha"
        );

        $respuesta = json_decode($verificar, true);

        if (!$respuesta['success']) {
            $error = 'Captcha no válido';
        }
    }
    // 🔼 FIN DEL RECAPTCHA 🔼

    // 👇 SOLO entra aquí si el captcha pasó
    if (empty($error)) {

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

                $update = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?");
                $update->execute([$usuario['id']]);

                header('Location: cocina.php');
                exit;
            }

        } else {
            $error = 'Usuario o contraseña incorrectos';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Sweet Bakery</title>
    <link rel="stylesheet" href="Css/style.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="js/jquery.min.js"></script>
    <style>
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

            <div class="g-recaptcha" data-sitekey="6LfvHVcsAAAAABTIG6u0l5LJpfYmEIchC4NTVVRO"></div>
            <br />

            <button type="submit" class="btn-auth">Ingresar</button>
        </form>

        <div class="link">
            ¿No tienes cuenta? <a href="formulario_usuario.php">Regístrate</a>
        </div>
    </div>
</body>

</html>