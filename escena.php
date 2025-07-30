<?php
$conn = new mysqli("localhost", "root", "", "juego_decisiones");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM escenas WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "<h2>Fin del juego. No hay más escenas.</h2>";
    exit();
}

$escena = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escena <?= $escena['id'] ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container show">
        <h1>Código Roto</h1>
        <p><?= htmlspecialchars($escena['texto']) ?></p>

        <div class="options">
            <form action="guardar_respuesta.php" method="POST">
                <input type="hidden" name="id_escena" value="<?= $escena['id'] ?>">
                <button class="button-start" name="opcion" value="a"><?= htmlspecialchars($escena['opcion_a']) ?></button>
                <button class="button-start" name="opcion" value="b"><?= htmlspecialchars($escena['opcion_b']) ?></button>
            </form>
        </div>

        <p class="disclaimer fade-in-text">Tus decisiones serán registradas de forma anónima.</p>
    </div>
    <script src="script.js"></script>
</body>
</html>
