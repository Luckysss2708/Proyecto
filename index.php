<?php
// Cargar estado del juego si existe
session_start();
$estadoGuardado = isset($_COOKIE['dilemasGameState']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dilemas Morales - Inicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="background-animated"></div>

    <div class="container show">
        <h1>Dilemas Morales</h1>
        <p>
            En este juego tomarás decisiones difíciles con implicaciones éticas. <br>
            Cada elección que hagas será registrada y comparada con las decisiones de otros jugadores.
        </p>
        <p>
            ¿Seguirás el camino del deber, el bienestar común o tus emociones?
        </p>

        <div class="options">
            <?php if ($estadoGuardado): ?>
                <a href="juego.php" class="button-start">Continuar aventura</a>
                <a href="juego.php?reset=1" class="button-start">Empezar nueva aventura</a>
            <?php else: ?>
                <a href="juego.php" class="button-start">Comenzar aventura</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
        console.log("Pantalla de inicio cargada");
    </script>
</body>
</html>
