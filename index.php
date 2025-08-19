<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código Roto</title>
    <link rel="stylesheet" href="css/base.css"> 
    <link rel="stylesheet" href="css/index.css">
    <style>
</style>
</head>
<body>
    <?php
session_start();
?>
<header>
  <nav class="nav-header">
    <div class="nav-left">
      <a href="index.html">Inicio</a>
      <a href="inspiracion.html">Inspiración</a>
      <a href="quien_soy.html">Quién soy</a>
      <a href="historia.html">Historia</a>
    </div>
    <div class="nav-right">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <div class="user-menu">
          <button id="user-button"><?= htmlspecialchars($_SESSION['usuario_nombre']) ?> ⏷</button>
          <div id="user-dropdown" class="user-dropdown hidden">
            <a href="emblemas.php">Emblemas</a>
            <a href="logout.php">Cerrar sesión</a>
          </div>
        </div>
      <?php else: ?>
        <a href="login.php" class="login-button">Iniciar sesión</a>
      <?php endif; ?>
    </div>
  </nav>
</header>
    <main>
        <div class="Principio">
            <h1>Código Roto</h1>
            <p>¿Estás listo para enfrentar dilemas que pondrán a prueba tu moralidad y tus principios?</p>
            <p>Inspirado en los dilemas clásicos del tranvía y las historias "Elige tu propia aventura".</p>
            <a href="escena.php?id=1" class="button-start">Comenzar Aventura</a>
            <p class="disclaimer fade-in-text">Tus decisiones serán registradas de forma anónima.</p>
        </div>  
    </main>
    <footer>
        <p>© 2025 Código Roto. Todos los derechos reservados.</p>
        <p>Desarrollado por Santino Trevisano</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
