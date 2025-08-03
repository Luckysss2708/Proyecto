<?php
session_start();
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['escena']) || !isset($data['opcion'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

$id_escena = (int)$data['escena'];
$opcion = $data['opcion'];
$jugador_hash = $_SESSION['jugador_hash'] ?? uniqid();

if ($opcion !== 'a' && $opcion !== 'b') {
    http_response_code(400);
    echo json_encode(['error' => 'Opción inválida']);
    exit;
}

// Verificar si ya respondió esta escena
$stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM respuestas WHERE id_escena = ? AND jugador_hash = ?");
$stmt_check->bind_param("is", $id_escena, $jugador_hash);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$count = $result_check->fetch_assoc()['count'];

if ($count > 0) {
    // Ya respondió: devolvemos solo los porcentajes sin insertar
    $total_result = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $id_escena");
    $total = (int)$total_result->fetch_assoc()['total'];

    $a_result = $conn->query("SELECT COUNT(*) AS a FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'");
    $a = (int)$a_result->fetch_assoc()['a'];

    $b = $total - $a;

    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Ya respondiste esta escena.',
        'a' => $total > 0 ? round(($a / $total) * 100) : 0,
        'b' => $total > 0 ? round(($b / $total) * 100) : 0
    ]);
    exit;
}

// Insertar respuesta
$stmt = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida, jugador_hash) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $id_escena, $opcion, $jugador_hash);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar respuesta']);
    exit;
}

// Calcular porcentajes
$total_result = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $id_escena");
$total = (int)$total_result->fetch_assoc()['total'];

$a_result = $conn->query("SELECT COUNT(*) AS a FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'");
$a = (int)$a_result->fetch_assoc()['a'];

$b = $total - $a;

header('Content-Type: application/json');
echo json_encode([
    'a' => $total > 0 ? round(($a / $total) * 100) : 0,
    'b' => $total > 0 ? round(($b / $total) * 100) : 0
]);

$conn->close();
