<?php
session_start();
require_once "../conexion.php"; // Ajusta la ruta según tu proyecto

header("Content-Type: application/json; charset=utf-8");

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["error" => "No autenticado"]);
    exit;
}

// Validar entrada
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['escena'], $data['opcion'])) {
    echo json_encode(["error" => "Datos incompletos"]);
    exit;
}

$usuario_id = (int) $_SESSION['usuario_id'];
$escena_id  = (int) $data['escena'];
$opcion     = $data['opcion'] === "a" ? "a" : "b";

// Verificar que la escena exista
$sql = "SELECT * FROM escenas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $escena_id);
$stmt->execute();
$res = $stmt->get_result();
$escena = $res->fetch_assoc();
$stmt->close();

if (!$escena) {
    echo json_encode(["error" => "Escena no encontrada"]);
    exit;
}

// Guardar la respuesta SIEMPRE (historial)
$stmt = $conn->prepare(
    "INSERT INTO respuestas (id_escena, opcion_elegida, usuario_id) VALUES (?, ?, ?)"
);
$stmt->bind_param("isi", $escena_id, $opcion, $usuario_id);
$stmt->execute();
$stmt->close();

// Calcular estadísticas globales de esa escena
$totalRes = $conn->query("SELECT COUNT(*) AS total FROM respuestas WHERE id_escena = $escena_id")->fetch_assoc();
$total = $totalRes['total'] ?? 0;

$aRes = $conn->query("SELECT COUNT(*) AS c FROM respuestas WHERE id_escena = $escena_id AND opcion_elegida = 'a'")->fetch_assoc();
$bRes = $conn->query("SELECT COUNT(*) AS c FROM respuestas WHERE id_escena = $escena_id AND opcion_elegida = 'b'")->fetch_assoc();

$porc_a = $total > 0 ? round(($aRes['c'] / $total) * 100, 1) : 0;
$porc_b = $total > 0 ? round(($bRes['c'] / $total) * 100, 1) : 0;

// Determinar siguiente escena según opción
$siguiente = ($opcion === "a") ? $escena['siguiente_a'] : $escena['siguiente_b'];

// Si no hay siguiente (es un final), guardar desbloqueo en usuario_finales
if (is_null($siguiente)) {
    // Buscar o registrar final correspondiente (si los estás mapeando)
    // Ejemplo: usar id de la escena como final
    $final_id = $escena_id;

    $stmt = $conn->prepare("INSERT IGNORE INTO usuario_finales (usuario_id, final_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $usuario_id, $final_id);
    $stmt->execute();
    $stmt->close();
}

// Respuesta JSON
echo json_encode([
    "a"         => $porc_a,
    "b"         => $porc_b,
    "siguiente" => $siguiente
]);
