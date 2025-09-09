<?php
include '../conexion.php'; 
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../RL/login.php");
    exit();
}

$usuario_id = (int)$_SESSION['usuario_id'];

// 1. Obtener todos los finales de la tabla `finales`
$sql_todos_finales = "SELECT id, nombre, descripcion FROM finales ORDER BY id ASC";
$result_todos = $conn->query($sql_todos_finales);

if (!$result_todos) {
    die("Error al consultar la base de datos: " . $conn->error);
}

// 2. Obtener los IDs de los finales que el usuario ha desbloqueado
$sql_desbloqueados = "SELECT final_id FROM usuario_finales WHERE usuario_id = ?";
$stmt_desbloqueados = $conn->prepare($sql_desbloqueados);
$stmt_desbloqueados->bind_param("i", $usuario_id);
$stmt_desbloqueados->execute();
$result_desbloqueados = $stmt_desbloqueados->get_result();

$finales_desbloqueados = [];
while ($row = $result_desbloqueados->fetch_assoc()) {
    $finales_desbloqueados[] = $row['final_id'];
}
$stmt_desbloqueados->close();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Emblemas Desbloqueados</title>
    <link rel="stylesheet" href="../css/base.css" />
    <link rel="stylesheet" href="../css/emblemas.css" />
</head>
<body>
    <main class="container">
        <h1>Tus Emblemas</h1>
        <p class="disclaimer fade-in-text">Aquí puedes ver los finales de la historia que has descubierto.</p>

        <div class="emblemas-container">
            <?php
            while ($final = $result_todos->fetch_assoc()):
                $id_final = $final['id'];
                $desbloqueado = in_array($id_final, $finales_desbloqueados);
                $clase_css = $desbloqueado ? 'emblema-desbloqueado' : 'emblema-bloqueado';
            ?>
                <div class="emblema <?= $clase_css ?>">
                    <h3>
                        <?php echo $desbloqueado ? htmlspecialchars($final['nombre']) : 'Emblema Desconocido'; ?>
                    </h3>
                    <p>
                        <?php echo $desbloqueado ? htmlspecialchars($final['descripcion']) : 'Descubre este final para ver la descripción.'; ?>
                    </p>
                </div>
            <?php endwhile; ?>
        </div>
        
    </main>

    <footer>
        <div class="footer-buttons">
            <a href="escena.php" class="footer-button">Volver al juego</a>
            <a href="../index.php" class="footer-button">Volver al Menú Principal</a>
        </div>
    </footer>
</body>
</html>