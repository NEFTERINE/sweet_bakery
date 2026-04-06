<?php
session_start();
$usuario_logueado = isset($_SESSION['usuario_id']);
$usuario_nombre = $_SESSION['usuario_nombre'] ?? '';
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

<body>

  <!-- Navigation Tabs -->
  <nav class="nav-tabs">
    <button class="nav-tab active" onclick="switchModule('kitchen')">
      <span>🍳</span> Cocina
    </button>
    <button class="nav-tab" onclick="switchModule('shop')">
      <span>🛒</span> Tienda
    </button>
    <button class="nav-tab" onclick="switchModule('medals')">
      <span>🏆</span> Medallas
    </button>
    <button class="nav-tab" onclick="location.href='historial.php'">
      <span>🏆</span> Historial
    </button>

    <div class="nav-user">
      <?php if ($usuario_logueado): ?>

          <span style="color: #ff6b6b;">
            <?php echo htmlspecialchars($usuario_nombre); ?>
          </span>
          <button  onclick="location.href='controler/cerrar_sesion.php'"> 
            Cerrar Sesión
          </button>
        </div>
        <div>
          <button class="nav-tab" onclick="guardarPartida()"> 💾 Guardar </button>
        </div>
        <div>
          <button class="nav-tab" class="nav-tab" onclick="cargarPartida()"> 📂 Cargar </button>
        </div>
      <?php else: ?>
        <div>
          <a href="login.php">🔐 Iniciar Sesión</a>
          <a href="formulario_usuario.php">📝 Registrarse</a>
        </div>
      <?php endif; ?>
    </div>

  </nav>

  <script src="JS/sweet.js"></script>
</body>

</html>