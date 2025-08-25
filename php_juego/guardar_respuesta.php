<?php
session_start();
include '../conexion.php'; 

// Establecer el encabezado para que la respuesta sea JSON
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['escena']) || !isset($data['opcion'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

$id_escena = (int)$data['escena'];
$opcion = $data['opcion'];

// Usar el ID de usuario si ha iniciado sesión, de lo contrario usar un hash anónimo
$usuario_id = $_SESSION['usuario_id'] ?? null;
$jugador_hash = $_SESSION['jugador_hash'] ?? uniqid();
$_SESSION['jugador_hash'] = $jugador_hash;

if ($opcion !== 'a' && $opcion !== 'b') {
    http_response_code(400);
    echo json_encode(['error' => 'Opción inválida']);
    exit;
}

// Verificar si ya respondió esta escena
$stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM respuestas WHERE id_escena = ? AND usuario_id = ?");
$stmt_check->bind_param("ii", $id_escena, $usuario_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$count = $result_check->fetch_assoc()['count'];

if ($count > 0) {
    // Si ya respondió, calculamos porcentajes y devolvemos la siguiente escena
    $stmt_next = $conn->prepare("SELECT siguiente_a, siguiente_b FROM escenas WHERE id = ?");
    $stmt_next->bind_param("i", $id_escena);
    $stmt_next->execute();
    $next_result = $stmt_next->get_result()->fetch_assoc();
    $siguiente = ($opcion === 'a') ? $next_result['siguiente_a'] : $next_result['siguiente_b'];

    $total_result = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $id_escena");
    $total = $total_result->fetch_assoc()['total'];

    $a_result = $conn->query("SELECT COUNT(*) AS c FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'");
    $a_count = $a_result->fetch_assoc()['c'];

    $b_result = $conn->query("SELECT COUNT(*) AS c FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'b'");
    $b_count = $b_result->fetch_assoc()['c'];

    echo json_encode([
        'a' => $total > 0 ? round(($a_count / $total) * 100, 2) : 0,
        'b' => $total > 0 ? round(($b_count / $total) * 100, 2) : 0,
        'error' => 'Ya respondiste esta escena.',
        'siguiente' => $siguiente
    ]);
    exit;
}

// Insertar respuesta
$stmt_insert = $conn->prepare("INSERT INTO respuestas (id_escena, opcion_elegida, usuario_id) VALUES (?, ?, ?)");
$stmt_insert->bind_param("isi", $id_escena, $opcion, $usuario_id);
$stmt_insert->execute();

// Calcular porcentajes
$total_result = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $id_escena");
$total = $total_result->fetch_assoc()['total'];

$a_result = $conn->query("SELECT COUNT(*) AS c FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'a'");
$a_count = $a_result->fetch_assoc()['c'];

$b_result = $conn->query("SELECT COUNT(*) AS c FROM respuestas WHERE id_escena = $id_escena AND opcion_elegida = 'b'");
$b_count = $b_result->fetch_assoc()['c'];

// Consultar la siguiente escena
$stmt_next = $conn->prepare("SELECT siguiente_a, siguiente_b FROM escenas WHERE id = ?");
$stmt_next->bind_param("i", $id_escena);
$stmt_next->execute();
$next_result = $stmt_next->get_result()->fetch_assoc();

if (!$next_result) {
    // Manejar el caso de que la escena no exista (aunque debería estar cubierta)
    $siguiente = null;
} else {
    $siguiente = ($opcion === 'a') ? $next_result['siguiente_a'] : $next_result['siguiente_b'];
}


// Devolver datos
echo json_encode([
    'a' => $total > 0 ? round(($a_count / $total) * 100, 2) : 0,
    'b' => $total > 0 ? round(($b_count / $total) * 100, 2) : 0,
    'siguiente' => $siguiente
]);

$conn->close();
?>