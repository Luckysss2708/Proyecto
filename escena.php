<?php
// Incluís tu archivo de conexión que define $conn
include 'conexion.php';

// Obtener id de la escena, por GET o defecto a 1
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Consultar escena
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
    <link rel="stylesheet" href="css/escena.css" />
    <style>
        /* escena.css */

body {
    background-color: #121212;
    color: #f0f0f0;
    font-family: 'Courier New', Courier, monospace;
    margin: 0;
    padding: 0;
}

header {
    background-color: #1e1e1e;
    padding: 20px;
    text-align: center;
    border-bottom: 2px solid #444;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
}

header button {
    background-color: #f26c4f;
    color: white;
    border: none;
    padding: 10px 18px;
    margin: 5px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s;
}

header button:hover {
    background-color: #d55439;
}

main {
    max-width: 800px;
    margin: 160px auto;
    background-color: rgba(20, 20, 20, 0.95);
    padding: 40px;
    border: 2px dashed #555;
    border-radius: 10px;
    box-shadow: 0 0 30px #000;
}

main h1 {
    font-size: 2em;
    margin-bottom: 20px;
    text-shadow: 1px 1px 4px #000;
    color: #f26c4f;
}

main p {
    font-size: 1.2em;
    line-height: 1.8;
    white-space: pre-line;
}

main button {
    background-color: #444;
    color: #fff;
    border: 2px solid #666;
    padding: 10px 20px;
    margin: 10px 15px 0 0;
    font-size: 1em;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
}

main button:hover {
    background-color: #555;
    transform: scale(1.03);
}

#resultado {
    color: #f0f0f0;
    margin-top: 20px;
    font-size: 1.1em;
}

        </style>
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
        <div style="margin-top: 30px;">
            <button onclick="window.location.href='final.php'">Ver mi recorrido</button>
            <button onclick="window.location.href='emblemas.php'" style="margin-left: 10px;">Ver finales</button>
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
