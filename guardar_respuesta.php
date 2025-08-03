<?php
session_start();
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$id_escena = $data['escena'];
$opcion = $data['opcion'];
$jugador_hash = $_SESSION['jugador_hash'];

$stmt = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida, jugador_hash) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $id_escena, $opcion, $jugador_hash);
$stmt->execute();

// Calcular porcentajes
$total = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $id_escena")->fetch_assoc()['total'];
$a = $conn->query("SELECT COUNT(*) AS a FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'")->fetch_assoc()['a'];
$b = $total - $a;

echo json_encode([
    'a' => round(($a / $total) * 100),
    'b' => round(($b / $total) * 100)
]);

$conn->close();
?>
