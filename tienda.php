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

  <!-- Shop Module -->
  <section id="shop" class="module active">
    <div class="module-header">
      <h1 class="module-title">Tienda</h1>
      <div class="coin-display">
        <span class="coin-icon">$</span>
        <span id="shop-coins">100</span>
      </div>
    </div>


    <div class="shop-categories">
      <button class="category-btn active" data-category="basicos">Básicos</button>
      <button class="category-btn" data-category="especias">Especias</button>
      <button class="category-btn" data-category="utensilios">Utensilios</button>
      <button class="category-btn" data-category="decoracion">Decoración</button>
    </div>

    <div id="shop-grid" class="shop-grid">
      <!-- Items populated by JS -->
    </div>
  </section>

  <!-- Toast Notification -->
  <div id="toast" class="toast"></div>

  
<script src="JS/sweet.js"></script>
</body>
</html>