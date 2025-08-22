<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>.</title>
    <link rel="stylesheet" href="/Proyecto/css/base.css">
</head>
<body>
    <header>
          <nav class="nav-header">
    <div class="nav-left">
      <a href="/Proyecto/index.php">Inicio</a>
      <a href="/Proyecto/php_menu/inspiracion.php">Inspiración</a>
      <a href="/Proyecto/php_menu/quien_soy.php">Quién soy</a>
      <a href="/Proyecto/php_menu/historia.php">Historia</a>
    </div>
    <div class="nav-right">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="user-menu">
          <button id="user-button"><?= htmlspecialchars($_SESSION['usuario_nombre']) ?> ⏷</button>
          <div id="user-dropdown" class="user-dropdown hidden">
            <a href="/Proyecto/php_juego/emblemas.php">Emblemas</a>
            <a href="/Proyecto/RL/logout.php">Cerrar sesión</a>
          </div>
        </div>
      <?php else: ?>
        <a href="/Proyecto/RL/login.php" class="login-button">Iniciar sesión</a>
      <?php endif; ?>
    </div>
  </nav>
  </header>
</body>
</html>