<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse - Código Roto</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <div class="registro-container">
        <h2>Crear cuenta</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['exito'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['exito']); ?></p>
        <?php endif; ?>
        <form method="POST" action="procesar_registro.php">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Registrarse">
        </form>
    </div>
</body>
</html>
