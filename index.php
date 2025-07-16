<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = ""; // Usa tu contraseña si tienes
$dbname = "juego_decisiones";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener la escena actual desde la URL o usar la primera
$sceneId = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Obtener datos de la escena actual
$stmt = $conn->prepare("SELECT * FROM escenas WHERE id = ?");
$stmt->bind_param("i", $sceneId);
$stmt->execute();
$result = $stmt->get_result();
$escena = $result->fetch_assoc();

if (!$escena) {
    echo "<p>Escena no encontrada.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de Decisiones</title>
    <link rel="stylesheet" href="estilos.css"> <!-- Asegúrate de que este archivo exista -->
</head>
<body>
    <div class="background-animated"></div>

    <div class="container show">
        <h1>Escena <?php echo htmlspecialchars($escena['id']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($escena['texto'])); ?></p>

        <div class="options" id="game-options">
            <a href="index.php?id=<?php echo $escena['id'] + 1; ?>"
               class="button-start"
               data-current-scene-id="<?php echo $escena['id']; ?>"
               data-option-index="1"
               data-decision-id="decision_<?php echo $escena['id']; ?>_a"
               data-moral-impact="utilitarian"
               data-moral-value="1">
                <?php echo htmlspecialchars($escena['opcion_a']); ?>
                <span class="percentage-display" id="percentage-1"></span>
            </a>

            <a href="index.php?id=<?php echo $escena['id'] + 1; ?>"
               class="button-start"
               data-current-scene-id="<?php echo $escena['id']; ?>"
               data-option-index="2"
               data-decision-id="decision_<?php echo $escena['id']; ?>_b"
               data-moral-impact="deontological"
               data-moral-value="1">
                <?php echo htmlspecialchars($escena['opcion_b']); ?>
                <span class="percentage-display" id="percentage-2"></span>
            </a>
        </div>

        <p class="disclaimer">Tus elecciones afectarán el rumbo de la historia.</p>
    </div>

    <script src="main.js"></script> <!-- Aquí va tu JS -->
</body>
</html>
