
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

  <!-- Kitchen Module -->
  <section id="kitchen" class="module active">
    <div class="module-header">
      
      <h1 class="module-title">Mi Cocina</h1>
      <div class="coin-display">
        <span class="coin-icon">$</span>
        <span id="kitchen-coins">100</span>
      </div>
    </div>

    <div class="kitchen-grid">
      <div class="kitchen-item" onclick="openRecipeBook()">
        <div class="kitchen-item-icon">📖</div>
        <h3 class="kitchen-item-title">Libro de Recetas</h3>
        <p class="kitchen-item-desc">Ver todas las recetas disponibles</p>
      </div>

      <div class="kitchen-item oven-item" onclick="openOven()">
        <div class="kitchen-item-icon">🔥</div>  
        <h3 class="kitchen-item-title">Horno</h3>
        <p class="kitchen-item-desc">Hornea tus deliciosos postres</p>
      </div>

      <div class="kitchen-item coin-generator" onclick="generateCoins(this)">
        <div class="kitchen-item-icon">🐷💰</div> 
        <h3 class="kitchen-item-title">Alcancía </h3>
        <p class="kitchen-item-desc">Toca para ganar monedas</p>
      </div>
  </section>

  <!-- Recipe Book Modal -->
  <div id="recipe-modal" class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h2 class="modal-title">Libro de Recetas</h2>
        <button class="modal-close" onclick="closeModal('recipe-modal')">&times;</button>
      </div>
      <div class="modal-body">
        <div id="recipes-grid" class="recipes-grid">
          <!-- Recipes populated by JS -->
        </div>
      </div>
    </div>
  </div>

  <!-- Oven Modal -->
  <div id="oven-modal" class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h2 class="modal-title">🔥 Horno</h2>
        <button class="modal-close" onclick="closeModal('oven-modal')">&times;</button>
      </div>
      <div class="modal-body">
        <div class="oven-interior">
          <div class="oven-slots" id="oven-slots">
            <div class="oven-slot" data-slot="0" onclick="removeFromSlot(0)">+</div>
            <div class="oven-slot" data-slot="1" onclick="removeFromSlot(1)">+</div>
            <div class="oven-slot" data-slot="2" onclick="removeFromSlot(2)">+</div>
            <div class="oven-slot" data-slot="3" onclick="removeFromSlot(3)">+</div>
          </div>
        </div>

        <div class="inventory-section">
          <h3 class="inventory-title">Tu Inventario</h3>
          <div id="oven-inventory" class="inventory-grid">
            <!-- Inventory populated by JS -->
          </div>
        </div>

        <button id="bake-btn" class="bake-button" onclick="bake()" disabled>
          Selecciona ingredientes para hornear
        </button>
      </div>
    </div>
  </div>

  <!-- Inventory Modal -->
  <div id="inventory-modal" class="modal-overlay">
    <div class="modal">
      <div class="modal-header">
        <h2 class="modal-title">🎒 Mi Inventario</h2>
        <button class="modal-close" onclick="closeModal('inventory-modal')">&times;</button>
      </div>
      <div class="modal-body">
        <div id="full-inventory" class="inventory-grid">
          <!-- Inventory populated by JS -->
        </div>
        <div id="inventory-empty" class="empty-state" style="display: none;">
          <div class="empty-state-icon">🎒</div>
          <p class="empty-state-text">Tu inventario está vacío</p>
          <button class="buy-btn" style="width: auto; padding: 12px 24px;" onclick="closeModal('inventory-modal'); switchModule('shop');">
            Ir a la Tienda
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div id="toast" class="toast"></div>

  
<script src="JS/sweet.js"></script>
</body>
</html>