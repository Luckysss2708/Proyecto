
<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../conexion.php';

header("Content-Type: application/json; charset=utf-8");

function error_response($msg) {
    echo json_encode(["error" => $msg]);
    exit;
}

if (!isset($_SESSION['usuario_id'])) {
    error_response("No autenticado");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['escena'], $data['opcion'])) {
    error_response("Datos incompletos");
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
    error_response("Escena no encontrada");
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

// Unificar lógica de finales: usar el mismo mapeo que en escena.php
$final_mapping = [
    13 => 4, 15 => 2, 16 => 3, 23 => 5, 24 => 4, 26 => 10, 27 => 9, 28 => 11, 30 => 4,
    32 => 5, 33 => 4, 34 => 1, 35 => 17, 37 => 6, 38 => 7, 40 => 16, 41 => 8, 45 => 12,
    46 => 7, 47 => 13, 49 => 14, 50 => 15, 55 => 18, 58 => 14, 59 => 20, 60 => 5, 62 => 13,
    63 => 21, 64 => 10,
];

if (is_null($siguiente)) {
    if (isset($final_mapping[$escena_id])) {
        $final_id = $final_mapping[$escena_id];
        $stmt = $conn->prepare("INSERT INTO usuario_finales (usuario_id, final_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE fecha_desbloqueo = NOW()");
        $stmt->bind_param("ii", $usuario_id, $final_id);
        $stmt->execute();
        $stmt->close();
    }
}

echo json_encode([
    "a"         => $porc_a,
    "b"         => $porc_b,
    "siguiente" => $siguiente
]);
