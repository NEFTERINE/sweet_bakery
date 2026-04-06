

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="Css/style.css">
  <title>Sweet Bakery - Juego de Panadería</title>

</head>
<body>

<?php
require_once ('menu.php');
?>

  <!-- Medals Module -->
  <section id="medals" class="module active">
    <div class="module-header">
      <h1 class="module-title">Salón de Medallas</h1>
      <div class="coin-display">
        <span class="coin-icon">$</span>
        <span id="medals-coins">100</span>
      </div>
    </div>

    <div class="progress-bar">
      <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
      <span class="progress-text" id="progress-text">0 / 8 recetas</span>
    </div>

    <div id="medals-grid" class="medals-grid">
      <!-- Medals populated by JS -->
    </div>
  </section>

  <!-- Toast Notification -->
  <div id="toast" class="toast"></div>

  
<script src="JS/sweet.js"></script>
</body>
</html>