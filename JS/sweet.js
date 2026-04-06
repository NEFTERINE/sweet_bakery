// =============================================
// ESTADO DEL JUEGO - GLOBAL
// =============================================
const gameState = {
  coins: 100,
  inventory: [],
  createdDesserts: [],
  ovenSlots: [null, null, null, null]
};

// =============================================
// CARGAR DATOS GUARDADOS
// =============================================
function loadGame() {
  const savedData = localStorage.getItem('sweetBakeryGame');
  if (savedData) {
    try {
      const parsed = JSON.parse(savedData);
      gameState.coins = parsed.coins !== undefined ? parsed.coins : 100;
      gameState.inventory = parsed.inventory || [];
      gameState.createdDesserts = parsed.createdDesserts || [];
      gameState.ovenSlots = parsed.ovenSlots || [null, null, null, null];
    } catch(e) {
      console.error('Error cargando datos:', e);
    }
  }
  updateAllCoins();
}

// =============================================
// GUARDAR DATOS
// =============================================
function saveGame() {
  localStorage.setItem('sweetBakeryGame', JSON.stringify({
    coins: gameState.coins,
    inventory: gameState.inventory,
    createdDesserts: gameState.createdDesserts,
    ovenSlots: gameState.ovenSlots
  }));
}

// =============================================
// ACTUALIZAR MONEDAS EN TODOS LOS ELEMENTOS
// =============================================
function updateAllCoins() {
  const coinElements = ['kitchen-coins', 'shop-coins', 'medals-coins'];
  coinElements.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.textContent = gameState.coins;
  });
  saveGame();
}

// =============================================
// NAVEGACIÓN ENTRE PÁGINAS
// =============================================
function switchModule(moduleName) {
  const routes = {
    shop: 'tienda.php',
    kitchen: 'cocina.php',
    medals: 'medallas.php',
    menu: 'index.php'
  };
  
  if (routes[moduleName]) {
    window.location.href = routes[moduleName];
  }
}

// =============================================
// DATOS DEL JUEGO
// =============================================
const recipes = [
  { id: 1, name: 'Pan Básico', icon: '🍞', ingredients: ['harina', 'agua', 'levadura'], reward: 20 },
  { id: 2, name: 'Galletas', icon: '🍪', ingredients: ['harina', 'azucar', 'mantequilla'], reward: 25 },
  { id: 3, name: 'Pastel de Chocolate', icon: '🎂', ingredients: ['harina', 'chocolate', 'huevos', 'azucar'], reward: 50 },
  { id: 4, name: 'Croissant', icon: '🥐', ingredients: ['harina', 'mantequilla', 'levadura'], reward: 35 },
  { id: 5, name: 'Donas', icon: '🍩', ingredients: ['harina', 'azucar', 'aceite'], reward: 30 },
  { id: 6, name: 'Cupcake', icon: '🧁', ingredients: ['harina', 'azucar', 'crema'], reward: 40 },
  { id: 7, name: 'Tarta de Frutas', icon: '🥧', ingredients: ['harina', 'frutas', 'azucar', 'mantequilla'], reward: 55 },
  { id: 8, name: 'Pan Dulce', icon: '🥮', ingredients: ['harina', 'azucar', 'canela', 'mantequilla'], reward: 45 }
];

const shopItems = {
  basicos: [
    { id: 'harina', name: 'Harina', icon: '🌾', price: 10 },
    { id: 'azucar', name: 'Azúcar', icon: '🧂', price: 8 },
    { id: 'huevos', name: 'Huevos', icon: '🥚', price: 12 },
    { id: 'mantequilla', name: 'Mantequilla', icon: '🧈', price: 15 },
    { id: 'agua', name: 'Agua', icon: '💧', price: 5 },
    { id: 'levadura', name: 'Levadura', icon: '🫧', price: 8 }
  ],
  especias: [
    { id: 'canela', name: 'Canela', icon: '🪵', price: 20 },
    { id: 'vainilla', name: 'Vainilla', icon: '🌿', price: 25 },
    { id: 'chocolate', name: 'Chocolate', icon: '🍫', price: 18 }
  ],
  utensilios: [
    { id: 'molde', name: 'Molde', icon: '🍳', price: 50 },
    { id: 'batidora', name: 'Batidora', icon: '🥄', price: 80 },
    { id: 'rodillo', name: 'Rodillo', icon: '📏', price: 35 }
  ],
  decoracion: [
    { id: 'crema', name: 'Crema', icon: '🍦', price: 22 },
    { id: 'frutas', name: 'Frutas', icon: '🍓', price: 28 },
    { id: 'chispas', name: 'Chispas', icon: '✨', price: 15 },
    { id: 'aceite', name: 'Aceite', icon: '🫒', price: 12 }
  ]
};

let currentCategory = 'basicos';

// =============================================
// INICIALIZACIÓN SEGÚN LA PÁGINA
// =============================================
document.addEventListener('DOMContentLoaded', () => {
  // Cargar datos guardados
  loadGame();
  
  // Detectar en qué página estamos
  const currentPage = window.location.pathname.split('/').pop();
  
  // Inicializar según la página
  if (currentPage === 'cocina.php' || currentPage === '') {
    initKitchenPage();
  } else if (currentPage === 'tienda.php') {
    initShopPage();
  } else if (currentPage === 'medallas.php') {
    initMedalsPage();
  }
  
  // Configurar modales (para todas las páginas)
  setupModals();
});

// =============================================
// INICIALIZAR PÁGINA DE COCINA
// =============================================
function initKitchenPage() {
  updateAllCoins();
  renderRecipes();
  renderMedals();
}

// =============================================
// INICIALIZAR PÁGINA DE TIENDA
// =============================================
function initShopPage() {
  updateAllCoins();
  setupShopCategories();
  renderShop();
}

// =============================================
// INICIALIZAR PÁGINA DE MEDALLAS
// =============================================
function initMedalsPage() {
  updateAllCoins();
  renderMedals();
}

// =============================================
// CONFIGURAR MODALES
// =============================================
function setupModals() {
  document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) {
        overlay.classList.remove('active');
      }
    });
  });
}

// =============================================
// FUNCIONES DE MODALES
// =============================================
function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.add('active');
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.remove('active');
}

function openRecipeBook() {
  renderRecipes();
  openModal('recipe-modal');
}

function openOven() {
  renderOvenInventory();
  openModal('oven-modal');
}

function openInventory() {
  renderFullInventory();
  openModal('inventory-modal');
}

// =============================================
// FUNCIONES DE COCINA
// =============================================
function generateCoins(element) {
  const amount = Math.floor(Math.random() * 10) + 5;
  gameState.coins += amount;
  updateAllCoins();
  
  if (element) {
    element.classList.add('shake');
    createFlyingCoins(element.querySelector('.kitchen-item-icon') || element);
    createCoinExplosion(element.querySelector('.kitchen-item-icon') || element);
    
    const rect = element.getBoundingClientRect();
    createFloatingNumber(rect.left + rect.width / 2, rect.top, amount);
    
    setTimeout(() => element.classList.remove('shake'), 300);
  }
  
  showToast(`🎉 +${amount} monedas 🎉`);
}

function renderRecipes() {
  const grid = document.getElementById('recipes-grid');
  if (!grid) return;
  
  grid.innerHTML = recipes.map(recipe => {
    const created = gameState.createdDesserts.includes(recipe.id);
    return `
      <div class="recipe-card ${created ? '' : 'locked'}">
        <div class="recipe-icon">${recipe.icon}</div>
        <div class="recipe-name">${recipe.name}</div>
        <div class="recipe-ingredients">${recipe.ingredients.join(', ')}</div>
        <div class="recipe-status ${created ? 'unlocked' : 'locked'}">
          ${created ? '✓ Creado' : '🔒 Por descubrir'}
        </div>
      </div>
    `;
  }).join('');
}

// =============================================
// FUNCIONES DEL HORNO
// =============================================
function renderOvenInventory() {
  const grid = document.getElementById('oven-inventory');
  if (!grid) return;
  
  const grouped = {};
  gameState.inventory.forEach(item => {
    if (!grouped[item.id]) {
      grouped[item.id] = { ...item, qty: 0 };
    }
    grouped[item.id].qty++;
  });
  
  const items = Object.values(grouped);
  
  if (items.length === 0) {
    grid.innerHTML = `
      <div style="width:100%;text-align:center;padding:20px;color:var(--muted-foreground);">
        🎒 No tienes ingredientes. ¡Ve a la tienda!
      </div>
    `;
  } else {
    grid.innerHTML = items.map(item => `
      <div class="inventory-item" onclick="addToOven('${item.id}')">
        <div class="inventory-item-icon">${item.icon}</div>
        <div class="inventory-item-name">${item.name}</div>
        <div class="inventory-item-qty">x${item.qty}</div>
      </div>
    `).join('');
  }
  
  updateOvenSlots();
}

function addToOven(itemId) {
  const emptySlot = gameState.ovenSlots.findIndex(s => s === null);
  if (emptySlot === -1) {
    showToast('El horno está lleno');
    return;
  }
  
  const itemIndex = gameState.inventory.findIndex(i => i.id === itemId);
  if (itemIndex === -1) return;
  
  const item = gameState.inventory.splice(itemIndex, 1)[0];
  gameState.ovenSlots[emptySlot] = item;

  saveGame();
  renderOvenInventory();
}

function removeFromSlot(slotIndex) {
  const item = gameState.ovenSlots[slotIndex];
  if (item) {
    gameState.inventory.push(item);
    gameState.ovenSlots[slotIndex] = null;
    saveGame();
    renderOvenInventory();
  }
}

function updateOvenSlots() {
  const slots = document.querySelectorAll('.oven-slot');
  slots.forEach((slot, i) => {
    const item = gameState.ovenSlots[i];
    if (item) {
      slot.innerHTML = item.icon;
      slot.classList.add('filled');
    } else {
      slot.innerHTML = '+';
      slot.classList.remove('filled');
    }
  });
  
  updateBakeButton();
}

function updateBakeButton() {
  const btn = document.getElementById('bake-btn');
  if (!btn) return;
  
  const filledSlots = gameState.ovenSlots.filter(s => s !== null);
  
  if (filledSlots.length === 0) {
    btn.disabled = true;
    btn.textContent = '📦 Selecciona ingredientes para hornear';
  } else {
    btn.disabled = false;
    btn.textContent = `🔥 Hornear (${filledSlots.length} ingredientes)`;
  }
}

function bake() {
  const ingredients = gameState.ovenSlots.filter(s => s !== null).map(s => s.id);
  
  if (ingredients.length === 0) return;
  
  const matchedRecipe = recipes.find(recipe => {
    if (recipe.ingredients.length !== ingredients.length) return false;
    return recipe.ingredients.every(ing => ingredients.includes(ing));
  });
  
  flashOven();
  
  gameState.ovenSlots = [null, null, null, null];
  
  if (matchedRecipe) {
    const isNewRecipe = !gameState.createdDesserts.includes(matchedRecipe.id);
    
    if (isNewRecipe) {
      gameState.createdDesserts.push(matchedRecipe.id);
      createConfetti();
      createStars(document.querySelector('.oven-interior'));
      showCelebrationMessage(`¡NUEVA RECETA! ${matchedRecipe.name}`, matchedRecipe.icon);
    } else {
      createStars(document.querySelector('.oven-interior'));
    }
    
    gameState.coins += matchedRecipe.reward;
    updateAllCoins();
    
    // REGISTRAR EL HORNEADO
    registrarHorneado(matchedRecipe);
    
    const ovenRect = document.querySelector('.oven-interior').getBoundingClientRect();
    createFloatingNumber(ovenRect.left + ovenRect.width / 2, ovenRect.top, matchedRecipe.reward);
    
    showToast(`🎉 Creaste ${matchedRecipe.name}! +${matchedRecipe.reward} monedas 🎉`);
    renderMedals();
  } else {
    showToast('😢 No salió nada... ¡Intenta otra combinación!');
  }

  saveGame();
  renderOvenInventory();
}

// =============================================
// FUNCIONES DE TIENDA
// =============================================
function setupShopCategories() {
  document.querySelectorAll('.category-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentCategory = btn.dataset.category;
      renderShop();
    });
  });
}

function renderShop() {
  const grid = document.getElementById('shop-grid');
  if (!grid) return;
  
  const items = shopItems[currentCategory];
  
  grid.innerHTML = items.map(item => {
    const owned = gameState.inventory.filter(i => i.id === item.id).length;
    return `
      <div class="shop-item">
        <div class="shop-item-icon">${item.icon}</div>
        <div class="shop-item-name">${item.name}</div>
        <div class="shop-item-price">
          <span class="coin-icon" style="width:16px;height:16px;font-size:10px;">$</span>
          ${item.price}
        </div>
        ${owned > 0 ? `<div style="font-size:12px;color:var(--muted-foreground);margin-bottom:8px;">Tienes: ${owned}</div>` : ''}
        <button class="buy-btn" onclick="buyItem('${item.id}')" ${gameState.coins < item.price ? 'disabled' : ''}>
          ${gameState.coins >= item.price ? '🛒 Comprar' : '💰 Insuficiente'}
        </button>
      </div>
    `;
  }).join('');
}

function buyItem(itemId) {
  const allItems = Object.values(shopItems).flat();
  const item = allItems.find(i => i.id === itemId);
  
  if (item && gameState.coins >= item.price) {
    gameState.coins -= item.price;
    gameState.inventory.push({ ...item });
    updateAllCoins();
    renderShop();
    saveGame();
    
    // REGISTRAR LA COMPRA
    registrarCompra(item);
    
    const shopItem = document.querySelector(`.shop-item:has(.buy-btn[onclick="buyItem('${itemId}')"])`);
    if (shopItem) {
      createStars(shopItem);
      const rect = shopItem.getBoundingClientRect();
      createFloatingNumber(rect.left + rect.width / 2, rect.top, -item.price);
    }
    
    showToast(`✨ Compraste ${item.name} ✨`);
  } else {
    showToast(`❌ No tienes suficientes monedas para ${item.name}`);
  }
}

// =============================================
// FUNCIONES DE INVENTARIO
// =============================================
function renderFullInventory() {
  const grid = document.getElementById('full-inventory');
  const emptyState = document.getElementById('inventory-empty');
  
  if (!grid) return;
  
  const grouped = {};
  gameState.inventory.forEach(item => {
    if (!grouped[item.id]) {
      grouped[item.id] = { ...item, qty: 0 };
    }
    grouped[item.id].qty++;
  });
  
  const items = Object.values(grouped);
  
  if (items.length === 0) {
    if (grid) grid.style.display = 'none';
    if (emptyState) emptyState.style.display = 'block';
  } else {
    if (grid) grid.style.display = 'flex';
    if (emptyState) emptyState.style.display = 'none';
    grid.innerHTML = items.map(item => `
      <div class="inventory-item">
        <div class="inventory-item-icon">${item.icon}</div>
        <div class="inventory-item-name">${item.name}</div>
        <div class="inventory-item-qty">x${item.qty}</div>
      </div>
    `).join('');
  }
}

// =============================================
// FUNCIONES DE MEDALLAS
// =============================================
function renderMedals() {
  const grid = document.getElementById('medals-grid');
  const progressFill = document.getElementById('progress-fill');
  const progressText = document.getElementById('progress-text');
  
  if (!grid) return;
  
  const created = gameState.createdDesserts.length;
  const total = recipes.length;
  const percent = (created / total) * 100;
  
  if (progressFill) progressFill.style.width = percent + '%';
  if (progressText) progressText.textContent = `${created} / ${total} recetas`;
  
  if (created === total && !window._celebratedComplete) {
    window._celebratedComplete = true;
    createConfetti();
    createConfetti();
    showCelebrationMessage('¡MAESTRO PANADERO! 🏆', '🏆');
  }
  
  grid.innerHTML = recipes.map(recipe => {
    const earned = gameState.createdDesserts.includes(recipe.id);
    return `
      <div class="medal-card ${earned ? 'earned' : 'locked'}">
        <div class="medal-icon">${recipe.icon}</div>
        <div class="medal-name">${recipe.name}</div>
        ${earned ? '<div class="medal-date">🏅 Completado</div>' : '<div class="medal-date">❓ Por descubrir</div>'}
      </div>
    `;
  }).join('');
}

// =============================================
// TOAST NOTIFICACIONES
// =============================================
function showToast(message) {
  const toast = document.getElementById('toast');
  if (!toast) return;
  
  toast.textContent = message;
  toast.classList.add('show');
  
  setTimeout(() => {
    toast.classList.remove('show');
  }, 2500);
}

// =============================================
// ========== BOTONES GUARDAR/CARGAR ==========
// =============================================

// GUARDAR PARTIDA EN EL SERVIDOR
async function guardarPartida() {
  if (!confirm('¿Guardar partida actual?')) return;
  
  showToast('💾 Guardando partida...');
  
  const data = {
    coins: gameState.coins,
    inventory: gameState.inventory,
    createdDesserts: gameState.createdDesserts
  };
  
  try {
    const response = await fetch('controler/guardar_partida.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });
    
    const resultado = await response.json();
    
    if (resultado.success) {
      showToast('✅ ¡Partida guardada con éxito!');
    } else {
      showToast('❌ Error: ' + (resultado.error || 'desconocido'));
    }
  } catch(e) {
    console.error('Error:', e);
    showToast('❌ Error de conexión');
  }
}

// CARGAR PARTIDA DEL SERVIDOR
async function cargarPartida() {
  if (!confirm('¿Cargar partida guardada? Se perderán los cambios no guardados.')) return;
  
  showToast('📀 Cargando partida...');
  
  try {
    const response = await fetch('controler/cargar_partida.php');
    const data = await response.json();
    
    if (data.success) {
      gameState.coins = data.coins;
      gameState.inventory = data.inventory || [];
      gameState.createdDesserts = data.createdDesserts || [];
      gameState.ovenSlots = [null, null, null, null];
      
      updateAllCoins();
      renderMedals();
      renderRecipes();
      
      if (typeof renderShop === 'function') renderShop();
      if (typeof renderOvenInventory === 'function') renderOvenInventory();
      if (typeof renderFullInventory === 'function') renderFullInventory();
      
      showToast('✅ ¡Partida cargada con éxito!');
    } else {
      showToast('❌ No hay partida guardada');
    }
  } catch(e) {
    console.error('Error:', e);
    showToast('❌ Error de conexión');
  }
}

// Hacer las funciones globales
window.guardarPartida = guardarPartida;
window.cargarPartida = cargarPartida;

// =============================================
// EXPORTAR FUNCIONES GLOBALES (para onclick)
// =============================================
window.switchModule = switchModule;
window.openModal = openModal;
window.closeModal = closeModal;
window.openRecipeBook = openRecipeBook;
window.openOven = openOven;
window.openInventory = openInventory;
window.generateCoins = generateCoins;
window.addToOven = addToOven;
window.removeFromSlot = removeFromSlot;
window.bake = bake;
window.buyItem = buyItem;
window.showToast = showToast;

// =============================================
// FUNCIONES DE ANIMACIONES
// =============================================

function createConfetti() {
  const container = document.createElement('div');
  container.className = 'confetti-container';
  document.body.appendChild(container);
  
  const colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FFB347', '#FF69B4'];
  const shapes = ['🎉', '✨', '⭐', '🎊', '🍰', '🧁', '🍪'];
  
  for (let i = 0; i < 150; i++) {
    const confetti = document.createElement('div');
    confetti.className = 'confetti';
    
    if (Math.random() > 0.7) {
      confetti.innerHTML = shapes[Math.floor(Math.random() * shapes.length)];
      confetti.style.fontSize = (Math.random() * 20 + 10) + 'px';
      confetti.style.width = 'auto';
      confetti.style.height = 'auto';
      confetti.style.backgroundColor = 'transparent';
    } else {
      confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      confetti.style.width = Math.random() * 12 + 6 + 'px';
      confetti.style.height = Math.random() * 12 + 6 + 'px';
    }
    
    confetti.style.left = Math.random() * 100 + '%';
    confetti.style.animationDelay = Math.random() * 2 + 's';
    confetti.style.animationDuration = Math.random() * 2 + 2 + 's';
    
    container.appendChild(confetti);
  }
  
  setTimeout(() => {
    container.remove();
  }, 4000);
}

function createFlyingCoins(element) {
  const rect = element.getBoundingClientRect();
  const centerX = rect.left + rect.width / 2;
  const centerY = rect.top + rect.height / 2;
  
  for (let i = 0; i < 15; i++) {
    const coin = document.createElement('div');
    coin.innerHTML = ['💰', '🪙', '💎', '✨'][Math.floor(Math.random() * 4)];
    coin.className = 'coin-particle';
    coin.style.left = centerX + 'px';
    coin.style.top = centerY + 'px';
    coin.style.fontSize = (Math.random() * 20 + 20) + 'px';
    
    const angle = (Math.random() * Math.PI * 2);
    const distance = Math.random() * 150 + 50;
    const tx = Math.cos(angle) * distance;
    const ty = -Math.abs(Math.sin(angle) * distance) - 50;
    
    coin.style.setProperty('--tx', tx + 'px');
    coin.style.setProperty('--ty', ty + 'px');
    coin.style.setProperty('--tx2', tx * 1.5 + 'px');
    coin.style.setProperty('--ty2', ty * 1.8 + 'px');
    
    document.body.appendChild(coin);
    
    setTimeout(() => coin.remove(), 1000);
  }
}

function createCoinExplosion(element) {
  const rect = element.getBoundingClientRect();
  const centerX = rect.left + rect.width / 2;
  const centerY = rect.top + rect.height / 2;
  
  for (let i = 0; i < 30; i++) {
    const coin = document.createElement('div');
    coin.innerHTML = ['💰', '🪙', '💎', '✨', '⭐'][Math.floor(Math.random() * 5)];
    coin.className = 'coin-burst';
    coin.style.left = centerX + 'px';
    coin.style.top = centerY + 'px';
    coin.style.fontSize = (Math.random() * 24 + 16) + 'px';
    
    const angle = Math.random() * Math.PI * 2;
    const distance = Math.random() * 200 + 50;
    const dx = Math.cos(angle) * distance;
    const dy = Math.sin(angle) * distance - 100;
    
    coin.style.setProperty('--dx', dx + 'px');
    coin.style.setProperty('--dy', dy + 'px');
    
    document.body.appendChild(coin);
    
    setTimeout(() => coin.remove(), 800);
  }
}

function createFloatingNumber(x, y, amount) {
  const number = document.createElement('div');
  const prefix = amount > 0 ? '+' : '';
  number.innerHTML = `${prefix}${amount} 🪙`;
  number.className = 'floating-number';
  number.style.left = x + 'px';
  number.style.top = y + 'px';
  
  document.body.appendChild(number);
  
  setTimeout(() => number.remove(), 1000);
}

function showCelebrationMessage(message, emoji = '🎉') {
  const celebration = document.createElement('div');
  celebration.innerHTML = `${emoji} ${message} ${emoji}`;
  celebration.className = 'recipe-celebration';
  document.body.appendChild(celebration);
  
  setTimeout(() => {
    celebration.classList.add('fade-out');
    setTimeout(() => celebration.remove(), 500);
  }, 2000);
}

function createStars(element) {
  const rect = element.getBoundingClientRect();
  const centerX = rect.left + rect.width / 2;
  const centerY = rect.top + rect.height / 2;
  
  for (let i = 0; i < 20; i++) {
    const star = document.createElement('div');
    star.innerHTML = ['⭐', '✨', '🌟', '💫'][Math.floor(Math.random() * 4)];
    star.className = 'star-particle';
    star.style.left = centerX + (Math.random() - 0.5) * 100 + 'px';
    star.style.top = centerY + (Math.random() - 0.5) * 100 + 'px';
    star.style.fontSize = (Math.random() * 20 + 16) + 'px';
    
    document.body.appendChild(star);
    
    setTimeout(() => star.remove(), 1000);
  }
}

function flashOven() {
  const ovenInterior = document.querySelector('.oven-interior');
  if (ovenInterior) {
    ovenInterior.classList.add('oven-flash');
    setTimeout(() => ovenInterior.classList.remove('oven-flash'), 300);
  }
}
// =============================================
// ========== REGISTRO DE HORNEADOS Y COMPRAS ==========
// =============================================

async function registrarCompra(item) {
    if (!item?.id) return;
    try {
        const res = await fetch('controler/registrar_compra.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ item_id: item.id, item_nombre: item.name, precio: item.price })
        });
        if ((await res.json()).success) showToast(`📝 ${item.name} registrado`);
    } catch(e) {}
}

async function registrarHorneado(recipe) {
    if (!recipe?.id) return;
    try {
        const res = await fetch('controler/registrar_horneado.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ receta_id: recipe.id, receta_nombre: recipe.name, recompensa: recipe.reward })
        });
        if ((await res.json()).success) showToast(`📝 ${recipe.name} registrado`);
    } catch(e) {}
}

window.registrarCompra = registrarCompra;
window.registrarHorneado = registrarHorneado;