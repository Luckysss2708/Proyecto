<?php require_once __DIR__ . '/../config.php'; ?>
<header>
      <nav class="nav-header">
<div class="nav-left">
  <a href="<?= BASE_URL ?>/index.php">Inicio</a>
  <a href="<?= BASE_URL ?>/php_menu/inspiracion.php">Inspiración</a>
  <a href="<?= BASE_URL ?>/php_menu/quien_soy.php">Quién soy</a>
  <a href="<?= BASE_URL ?>/php_menu/historia.php">Historia</a>
</div>
<div class="nav-right">
  <?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="user-menu">
      <button id="user-button"><?= htmlspecialchars($_SESSION['usuario_nombre']) ?> ⏷</button>
      <div id="user-dropdown" class="user-dropdown hidden">
        <a href="<?= BASE_URL ?>/RL/logout.php">Cerrar sesión</a>
        <a href="<?= BASE_URL ?>/php_juego/emblemas.php" class="footer-button">Emblemas</a>
      </div>
    </div>
  <?php else: ?>
    <a href="<?= BASE_URL ?>/RL/login.php" class="login-button">Iniciar sesión</a>
  <?php endif; ?>
</div>
</nav>
</header>