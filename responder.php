<?php
header("Content-Type: application/json");
include 'db_config.php';

$data = json_decode(file_get_contents("php://input"), true);
$id_escena = intval($data["escena"]);
$opcion = $data["opcion"];

// Insertamos la respuesta
$stmt = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida) VALUES (?, ?)");
$stmt->bind_param("is", $id_escena, $opcion);
$stmt->execute();

// Contamos los votos por opción
$sql = "SELECT opcion_elegida, COUNT(*) as total FROM respuestas WHERE id_escena = ? GROUP BY opcion_elegida";
$stmt2 = $conn->prepare($sql);
$stmt2->bind_param("i", $id_escena);
$stmt2->execute();
$result = $stmt2->get_result();

$conteos = ['a' => 0, 'b' => 0];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $conteos[$row['opcion_elegida']] = $row['total'];
    $total += $row['total'];
}

$porcentaje_a = $total > 0 ? round(($conteos['a'] / $total) * 100) : 0;
$porcentaje_b = $total > 0 ? round(($conteos['b'] / $total) * 100) : 0;

echo json_encode(["a" => $porcentaje_a, "b" => $porcentaje_b]);
?>
