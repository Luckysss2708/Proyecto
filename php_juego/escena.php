<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /Proyecto/RL/login.php");
    exit();
}

include '../conexion.php'; 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$sql = "SELECT * FROM escenas WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("No se encontró la escena con id=$id");
}

$escena = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($escena['nombre']) ?> - Escena <?= htmlspecialchars($escena['id']) ?></title>
    <link rel="stylesheet" href="/Proyecto/css/escena.css" />
    <link rel="stylesheet" href="/Proyecto/css/base.css" />
</head>
<body>
    <main class="container">
        <h1><?= htmlspecialchars($escena['nombre']) ?></h1>
        <p><?= nl2br(htmlspecialchars($escena['texto'])) ?></p>

        <?php if ($escena['siguiente_a'] !== NULL && $escena['siguiente_b'] !== NULL): ?>
        <div class="opciones">
            <button data-escena="<?= $escena['id'] ?>" onclick="responder('a', <?= $escena['id'] ?>)">
                A: <?= htmlspecialchars($escena['opcion_a']) ?>
            </button>
            <button data-escena="<?= $escena['id'] ?>" onclick="responder('b', <?= $escena['id'] ?>)">
                B: <?= htmlspecialchars($escena['opcion_b']) ?>
            </button>
        </div>
        <?php else: ?>
            <p>Fin de la historia.</p>
        <?php endif; ?>

        <div id="resultado" class="resultado-oculto">
            <p>Resultados:</p>
            <p>Opción A: <span id="porcentaje-a"></span></p>
            <p>Opción B: <span id="porcentaje-b"></span></p>
        </div>
    </main>

    <footer>
        <div class="footer-buttons">
            <a href="/Proyecto/php_juego/reiniciar_partida.php" class="footer-button">Reiniciar Partida</a>
            <a href="/Proyecto/php_juego/finales.php" class="footer-button">Ver Finales</a>
            <a href="/Proyecto/php_juego/emblemas.php" class="footer-button">Emblemas</a>
            <a href="/Proyecto/index.php" class="footer-button">Volver al Menú</a>
        </div>
    </footer>

    <script src="/Proyecto/script.js"></script>

    <script>
    function responder(opcion, escenaId) {
        document.querySelectorAll('button').forEach(btn => btn.disabled = true);
        
        fetch('guardar_respuesta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                escena: escenaId,
                opcion: opcion
            })
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('La respuesta de la red no fue exitosa');
            }
            return res.json();
        })
        .then(data => {
            if (data.error) {
                document.getElementById('resultado').innerText = `Error: ${data.error}`;
                return;
            }

            document.getElementById('porcentaje-a').innerText = `${data.a}%`;
            document.getElementById('porcentaje-b').innerText = `${data.b}%`;
            document.getElementById('resultado').classList.add('resultado-visible');

            setTimeout(() => {
                window.location.href = `escena.php?id=${data.siguiente}`;
            }, 3000); // 3 segundos para que el usuario vea el resultado
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('resultado').innerText = "Error en la conexión. No se pudieron obtener los resultados.";
        });
    }
    </script>
</body>
</html>