<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse - Código Roto</title>
    <link rel="stylesheet" href="css/base.css">
    <style>
        .registro-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.6);
        }

        .registro-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .registro-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: none;
            background-color: #2b2b2b;
            color: #e0e0e0;
            border-bottom: 2px solid #555;
        }

        .registro-container input[type="submit"] {
            background-color: #9fc1a3;
            color: #121212;
            padding: 10px 15px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .error {
            color: red;
            text-align: center;
        }

        .success {
            color: lightgreen;
            text-align: center;
        }
    </style>
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
