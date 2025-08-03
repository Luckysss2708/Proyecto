<?php
session_start();
if (!isset($_SESSION['jugador_hash'])) {
    $_SESSION['jugador_hash'] = uniqid();
}

include 'conexion.php';

$id_escena = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM escenas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_escena);
$stmt->execute();
$result = $stmt->get_result();
$escena = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escena</title>
    <script src="script.js"></script>
</head>
<body>
    <h2>Escena <?php echo $escena['id']; ?></h2>
    <p><?php echo $escena['texto']; ?></p>

    <div style="margin-bottom: 20px;">
        <button onclick="window.location.href='final.php'">Ver mi recorrido</button>
    </div>

    <button onclick="responder('a', <?php echo $escena['id']; ?>)">A: <?php echo $escena['opcion_a']; ?></button>
    <button onclick="responder('b', <?php echo $escena['id']; ?>)">B: <?php echo $escena['opcion_b']; ?></button>

    <p id="resultado"></p>
</body>
</html>

