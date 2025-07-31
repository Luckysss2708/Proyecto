<?php
// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "juego_decisiones");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$id_escena = intval($_POST['id_escena']);
$opcion = ($_POST['opcion'] === 'a') ? 'a' : 'b';

// Guardar la respuesta en la base de datos
$stmt = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida) VALUES (?, ?)");
$stmt->bind_param("is", $id_escena, $opcion);
$stmt->execute();

// Consultar el texto y opciones de la escena actual
$escena = $conn->query("SELECT * FROM escenas WHERE id = $id_escena")->fetch_assoc();

// Consultar estadísticas de respuestas
$total = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $id_escena")->fetch_assoc()['total'];
$total_a = $conn->query("SELECT COUNT(*) AS a FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'")->fetch_assoc()['a'];
$total_b = $conn->query("SELECT COUNT(*) AS b FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'b'")->fetch_assoc()['b'];

$porcentaje_a = $total > 0 ? round(($total_a / $total) * 100, 1) : 0;
$porcentaje_b = $total > 0 ? round(($total_b / $total) * 100, 1) : 0;

// Calcular siguiente escena (por ahora +1)
$siguiente = $id_escena + 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados - Escena <?= $id_escena ?></title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/escena.css">
</head>
<body>
    <div class="container show">
        <h1>Resultados</h1>
        <p><?= htmlspecialchars($escena['texto']) ?></p>

        <div class="options">
            <div class="button-start" style="pointer-events: none;">
                <?= htmlspecialchars($escena['opcion_a']) ?><br>
                <strong><?= $porcentaje_a ?>%</strong> eligió esta opción
            </div>

            <div class="button-start" style="pointer-events: none;">
                <?= htmlspecialchars($escena['opcion_b']) ?><br>
                <strong><?= $porcentaje_b ?>%</strong> eligió esta opción
            </div>
        </div>

        <br><br>
        <a href="escena.php?id=<?= $siguiente ?>" class="button-start">Siguiente escena</a>

        <p class="disclaimer">Gracias por decidir. Tu voto ha sido registrado.</p>
    </div>

    <script src="script.js"></script>
</body>
</html>
