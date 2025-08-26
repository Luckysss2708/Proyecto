<?php
session_start();
// Se incluye el archivo de conexión. La ruta es directa porque ambos archivos están en el mismo nivel.
include 'conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código Roto</title>
    <link rel="stylesheet" href="/Proyecto/css/base.css">
    <link rel="stylesheet" href="/Proyecto/css/index.css">
    <style>
</style>
</head>
<body>
    <?php include 'FH/header.php'; ?>
    <main>
        <div class="Principio">
            <img src="/Proyecto/imagenes/logo.png" alt="Logo broken code" class="inspiration-image">
            <h1>¿Estás listo para enfrentar dilemas que pondrán a prueba tu moralidad y tus principios?</h1>
            <p>Inspirado en los dilemas clásicos del tranvía y las historias "Elige tu propia aventura".</p>
            <?php
            // Lógica para el botón "Comenzar/Continuar Aventura"
            $link = "/Proyecto/php_juego/escena.php?id=1";
            $button_text = "Comenzar Aventura";
            
            if (isset($_SESSION['usuario_id'])) {
                $usuario_id = $_SESSION['usuario_id'];
                
                // Buscar la última escena jugada por el usuario
                $sql = "SELECT id_escena FROM respuestas WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 1";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $last_escena = $result->fetch_assoc();
                    $last_id = $last_escena['id_escena'];
                    $link = "/Proyecto/php_juego/escena.php?id=" . ($last_id + 1);
                    $button_text = "Continuar Aventura";
                }
            }
            // Cerrar la conexión
            if (isset($conn)) {
                $conn->close();
            }
            ?>
            <a href="<?= htmlspecialchars($link) ?>" class="button-start"><?= htmlspecialchars($button_text) ?></a>
            <p class="disclaimer fade-in-text">Tus decisiones serán registradas de forma anónima.</p>
        </div>  
    </main>
    <?php include 'FH/footer.php'; ?> 
    <script src="/Proyecto/script.js"></script>
</body>
</html>