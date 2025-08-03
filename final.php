<?php
session_start();
include 'conexion.php';

$jugador_hash = $_SESSION['jugador_hash'];

$sql = "SELECT e.texto, 
               CASE r.opcion_elegida 
                    WHEN 'a' THEN e.opcion_a 
                    ELSE e.opcion_b 
               END AS eleccion
        FROM respuestas r
        JOIN escenas e ON r.id_escena = e.id
        WHERE r.jugador_hash = ?
        ORDER BY r.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $jugador_hash);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Recorrido</title>
</head>
<body>
    <h2>Tu recorrido en el juego</h2>

    <?php while ($fila = $result->fetch_assoc()): ?>
        <div style="margin-bottom: 20px;">
            <strong>Escena:</strong> <?php echo $fila['texto']; ?><br>
            <strong>Elegiste:</strong> <?php echo $fila['eleccion']; ?>
        </div>
    <?php endwhile; ?>

</body>
</html>
