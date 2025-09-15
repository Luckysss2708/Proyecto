<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../RL/login.php");
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

// Check if the current scene is a final one and unlock the corresponding ending
if ($escena['siguiente_a'] === NULL && $escena['siguiente_b'] === NULL) {
    // Map the scene ID to the corresponding ending ID
    $final_mapping = [
        13 => 4,
        15 => 2,
        16 => 3,
        23 => 5,
        24 => 4,
        26 => 10,
        27 => 9,
        28 => 11,
        30 => 4,
        32 => 5,
        33 => 4,
        34 => 1,
        35 => 17,
        37 => 6,
        38 => 7,
        40 => 16,
        41 => 8,
        45 => 12,
        46 => 7,
        47 => 13,
        49 => 14,
        50 => 15,
        55 => 18,
        58 => 14,
        59 => 20,
        60 => 5,
        62 => 13,
        63 => 21,
        64 => 10,
    ];

    if (isset($final_mapping[$id])) {
        $final_id = $final_mapping[$id];

        // Prepare and execute the SQL query to insert the unlocked ending
        $sql_insert_final = "INSERT INTO usuario_finales (usuario_id, final_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE fecha_desbloqueo = NOW()";
        $stmt = $conn->prepare($sql_insert_final);
        $stmt->bind_param("ii", $_SESSION['usuario_id'], $final_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($escena['nombre']) ?> - Escena <?= htmlspecialchars($escena['id']) ?></title>
    <link rel="stylesheet" href="../css/escena.css" />
    <link rel="stylesheet" href="../css/base.css" />
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
            <a href="reiniciar_partida.php" class="footer-button">Volver a Jugar</a>
        <?php endif; ?>

        <div id="resultado" class="resultado-oculto">
            <p>Resultados:</p>
            <p>Opción A: <span id="porcentaje-a"></span></p>
            <p>Opción B: <span id="porcentaje-b"></span></p>
        </div>
    </main>

    <footer>
        <div class="footer-buttons">
            <a href="reiniciar_partida.php" class="footer-button">Reiniciar Partida</a>
            <a href="emblemas.php" class="footer-button">Emblemas</a>
            <a href="../index.php" class="footer-button">Volver al Menú</a>
        </div>
    </footer>

    <script src="../script.js"></script>

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
            }, 3500); 
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('resultado').innerText = "Error en la conexión. No se pudieron obtener los resultados.";
        });
    }
    </script>
</body>
</html>