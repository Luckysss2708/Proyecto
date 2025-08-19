<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Código Roto</title>
    <link rel="stylesheet" href="css/base.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.6);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: none;
            background-color: #2b2b2b;
            color: #e0e0e0;
            border-bottom: 2px solid #555;
        }

        .login-container input[type="submit"] {
            background-color: #9fc1a3;
            color: #121212;
            padding: 10px 15px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .login-container p.register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .login-container p.register-link a {
            color: #9fc1a3;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .login-container p.register-link a:hover {
            color: #cceabb;
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
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form method="POST" action="procesar_login.php">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="submit" value="Ingresar">
        </form>
        <p class="register-link">
            ¿No tenés cuenta? <a href="registro.php">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>
