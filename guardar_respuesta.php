<?php
$conn = new mysqli("localhost", "root", "", "juego_decisiones");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id_escena = intval($_POST['id_escena']);
$opcion = ($_POST['opcion'] === 'a') ? 'a' : 'b';

// Guardar la respuesta
$stmt = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida) VALUES (?, ?)");
$stmt->bind_param("is", $id_escena, $opcion);
$stmt->execute();

// Consultar total de respuestas para esa escena
$sql_total = "SELECT COUNT(*) as total FROM respuestas WHERE id_escena = $id_escena";
$sql_a = "SELECT COUNT(*) as a FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'";
$sql_b = "SELECT COUNT(*) as b FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'b'";

$total = $conn->query($sql_total)->fetch_assoc()['total'];
$total_a = $conn->query($sql_a)->fetch_assoc()['a'];
$total_b = $conn->query($sql_b)->fetch_assoc()['b'];

$porcentaje_a = $total > 0 ? round(($total_a / $total) * 100, 1) : 0;
$porcentaje_b = $total > 0 ? round(($total_b / $total) * 100, 1) : 0;

// Consultar el texto de la escena para mostrarlo de nuevo
$escena = $conn->query("SELECT * FROM escenas WHERE id = $id_escena")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados - Escena <?= $id_escena ?></title>
    <link rel="stylesheet" href="style.css">
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
        <a href="escena.php?id=<?= $id_escena + 1 ?>" class="button-start">Siguiente escena</a>

        <p class="disclaimer">Gracias por decidir. Tu voto ha sido registrado.</p>
    </div>
    <script src="script.js"></script>
</body>
</html>
