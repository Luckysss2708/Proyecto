<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "juego_decisiones";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}

$scene_id = $_POST['scene_id'] ?? null;
$option_index = $_POST['option_index'] ?? null;

if (!$scene_id || !$option_index) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$opcion = $option_index == 1 ? 'a' : 'b';

$stmtInsert = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida) VALUES (?, ?)");
$stmtInsert->bind_param("is", $scene_id, $opcion);
$stmtInsert->execute();
$stmtInsert->close();

$stmtCountA = $conn->prepare("SELECT COUNT(*) FROM respuestas WHERE id_escena = ? AND opcion_elegida = 'a'");
$stmtCountA->bind_param("i", $scene_id);
$stmtCountA->execute();
$stmtCountA->bind_result($countA);
$stmtCountA->fetch();
$stmtCountA->close();

$stmtCountB = $conn->prepare("SELECT COUNT(*) FROM respuestas WHERE id_escena = ? AND opcion_elegida = 'b'");
$stmtCountB->bind_param("i", $scene_id);
$stmtCountB->execute();
$stmtCountB->bind_result($countB);
$stmtCountB->fetch();
$stmtCountB->close();

echo json_encode([
    'success' => true,
    'plays' => [
        'opcion1_plays' => $countA,
        'opcion2_plays' => $countB,
    ],
]);

$conn->close();
