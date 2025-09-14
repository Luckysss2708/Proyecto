<?php
include 'conexion.php'; 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código Roto</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
</style>
</head>
<body>
    <?php include 'FH/header.php'; ?>
    <main>
        <div class="Principio">
            <h1>CODIGO ROTO</h1>
            <p>Inspirado en los dilemas clásicos del tranvía y las historias "Elige tu propia aventura".</p>
            <?php
            $link = "php_juego/escena.php?id=1";
            $button_text = "Comenzar Aventura";
            
            if (isset($_SESSION['usuario_id'])) {
                $usuario_id = $_SESSION['usuario_id'];
                
                $sql = "SELECT id_escena FROM respuestas WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $last_escena = $result->fetch_assoc();
                    $last_id = $last_escena['id_escena'];
                    $link = "php_juego/escena.php?id=" . ($last_id + 1);
                    $button_text = "Continuar Aventura";
                }
            }
            if (isset($conn)) {
                $conn->close();
            }
            ?>
            <a href="<?= htmlspecialchars($link) ?>" class="button-start"><?= htmlspecialchars($button_text) ?></a>
            <p class="disclaimer fade-in-text">Tus decisiones serán registradas de forma anónima.</p>
        </div>  
    </main>
    <?php include 'FH/footer.php'; ?> 
    <script src="script.js"></script>
</body>
</html>