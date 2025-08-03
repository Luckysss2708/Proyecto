<?php
session_start();
if (!isset($_SESSION['jugador_hash'])) {
    $_SESSION['jugador_hash'] = uniqid();
}

include 'conexion.php';

$id_escena = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM escenas WHERE id = $id_escena";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("<h2>Fin del juego. No hay más escenas.</h2>");
}

$escena = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($escena['nombre']) ?> - Escena <?= htmlspecialchars($escena['id']) ?></title>
    <script>
    function responder(opcion, escenaId) {
        // Deshabilitar botones para esta escena para evitar múltiples respuestas
        document.querySelectorAll('button[data-escena="' + escenaId + '"]').forEach(btn => btn.disabled = true);

        fetch('guardar_respuesta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                escena: escenaId,
                opcion: opcion
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error === 'Ya respondiste esta escena.') {
                // Si ya respondiste, redirigir directamente a la siguiente escena
                window.location.href = `escena.php?id=${escenaId + 1}`;
                return;
            } else if (data.error) {
                document.getElementById("resultado").innerText = "Error: " + data.error;
                return;
            }

            document.getElementById("resultado").innerText =
                `Opción A: ${data.a}% — Opción B: ${data.b}%`;

            // Esperar 2 segundos antes de avanzar a la siguiente escena
            setTimeout(() => {
                window.location.href = `escena.php?id=${escenaId + 1}`;
            }, 2000);
        })
        .catch(() => {
            document.getElementById("resultado").innerText = "Error en la conexión";
        });
    }
    </script>
</head>
<body>
    <h1><?= htmlspecialchars($escena['nombre']) ?></h1>
    <h2>Escena <?= htmlspecialchars($escena['id']) ?></h2>
    <p><?= htmlspecialchars($escena['texto']) ?></p>

    <button data-escena="<?= $escena['id'] ?>" onclick="responder('a', <?= $escena['id'] ?>)">A: <?= htmlspecialchars($escena['opcion_a']) ?></button>
    <button data-escena="<?= $escena['id'] ?>" onclick="responder('b', <?= $escena['id'] ?>)">B: <?= htmlspecialchars($escena['opcion_b']) ?></button>

    <p id="resultado"></p>

    <div style="margin-top: 20px;">
        <button onclick="window.location.href='final.php'">Ver mi recorrido</button>
    </div>
</body>
</html>
