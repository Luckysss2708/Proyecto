<?php

include '../conexion.php'; 


$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;


$sql = "SELECT * FROM escenas WHERE id = $id";
$result = $conn->query($sql);

if (!$result) {
    die("Error en consulta SQL: " . $conn->error);
}

if ($result->num_rows == 0) {
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
    <script>
    function responder(opcion, escenaId) {
        // Deshabilitar botones para evitar múltiples clicks
        document.querySelectorAll('button[data-escena="' + escenaId + '"]').forEach(btn => btn.disabled = true);

        fetch('guardar_respuesta.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                escena: escenaId,
                opcion: opcion
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error === 'Ya respondiste esta escena.') {
                window.location.href = `escena.php?id=${data.siguiente}`;
                return;
            }
            if (data.error) {
                document.getElementById('resultado').innerText = "Error: " + data.error;
                return;
            }
            document.getElementById('resultado').innerText =
                `Opción A: ${data.a}% — Opción B: ${data.b}%`;

            setTimeout(() => {
                window.location.href = `escena.php?id=${data.siguiente}`;
            }, 2000);
        })
        .catch(() => {
            document.getElementById('resultado').innerText = "Error en la conexión";
        });
    }
    </script>
</head>
<body>
    <header>
        <div>
            <button onclick="window.location.href='final.php'">Ver mi recorrido</button>
            <button onclick="window.location.href='emblemas.php'" style="margin-left: 10px;">Ver Emblemas</button>
    </div>
</header>

    </div>
    </header>

<main>
    <h1><?= htmlspecialchars($escena['nombre']) ?></h1>
    <p><?= nl2br(htmlspecialchars($escena['texto'])) ?></p>

    <button data-escena="<?= $escena['id'] ?>" onclick="responder('a', <?= $escena['id'] ?>)">
        A: <?= htmlspecialchars($escena['opcion_a']) ?>
    </button>
    <button data-escena="<?= $escena['id'] ?>" onclick="responder('b', <?= $escena['id'] ?>)">
        B: <?= htmlspecialchars($escena['opcion_b']) ?>
    </button>
    <p id="resultado" style="margin-top: 20px; font-weight: bold;"></p>
</main>
</body>
</html>
<?php
$conn->close();
?>
