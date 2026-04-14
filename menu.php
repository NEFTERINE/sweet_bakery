<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuario_logueado = isset($_SESSION['usuario_id']);
$usuario_nombre = $_SESSION['usuario_nombre'] ?? '';
$usuario_tipo = $_SESSION['usuario_tipo'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Css/style.css">
  <link rel="stylesheet" href="Css/usuario.css">
  <title>Sweet Bakery - Juego de Panadería</title>
</head>
<style>
  .nav-tabs {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    padding: 10px 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin: 15px;
}

.nav-left, .nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.nav-tab {
    background: #f1f1f1;
    border: none;
    padding: 10px 15px;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.nav-tab:hover {
    background: #ff6b6b;
    color: white;
}

.nav-tab.active {
    background: #ff6b6b;
    color: white;
}

/* Usuario */
.user-name {
    font-weight: bold;
    color: #ff6b6b;
    margin-right: 10px;
}

/* Botones */
.btn-save, .btn-load {
    background: #4caf50;
    color: white;
    border: none;
    padding: 8px 10px;
    border-radius: 50%;
    cursor: pointer;
}

.btn-load {
    background: #2196f3;
}

.btn-logout {
    background: #ff4d4d;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 20px;
    cursor: pointer;
}

/* Invitado */
.btn-login, .btn-register {
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 20px;
    color: white;
}

.btn-login {
    background: #2196f3;
}

.btn-register {
    background: #ff6b6b;
}
</style>
<body>

<nav class="nav-tabs">

  <div class="nav-left">
    <button class="nav-tab active" onclick="switchModule('kitchen')">
      🍳 Cocina
    </button>
    <button class="nav-tab" onclick="switchModule('shop')">
      🛒 Tienda
    </button>
    <button class="nav-tab" onclick="switchModule('medals')">
      🏆 Medallas
    </button>
 <?php if ($usuario_logueado && $usuario_tipo === 'admin'): ?>
    <button class="nav-tab" onclick="location.href='historial.php'">
      📜 Historial
    </button>
    <button class="nav-tab" onclick="location.href='usuarios.php'">
        👥 Usuarios
    </button>
<?php endif; ?>
  </div>

  <div class="nav-right">
    <?php if ($usuario_logueado): ?>

      <span class="user-name">
        👤 <?php echo htmlspecialchars($usuario_nombre . ' (' . $usuario_tipo . ')'); ?>
      </span>

      <button class="btn-save" onclick="guardarPartida()">💾</button>
      <button class="btn-load" onclick="cargarPartida()">📂</button>
      <button class="btn-logout" onclick="location.href='controler/cerrar_sesion.php'">
        Cerrar
      </button>

    <?php else: ?>

      <a class="btn-login" href="login.php">🔐 Login</a>
      <a class="btn-register" href="formulario_usuario.php">📝 Registro</a>

    <?php endif; ?>
  </div>

</nav>

  <script src="JS/sweet.js"></script>
</body>

</html>