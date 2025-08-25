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
    <?php
session_start();
?>
<?php include 'FH/header.php'; ?>
    <main>
        <div class="Principio">
            <h1>Código Roto</h1>
            <p>¿Estás listo para enfrentar dilemas que pondrán a prueba tu moralidad y tus principios?</p>
            <p>Inspirado en los dilemas clásicos del tranvía y las historias "Elige tu propia aventura".</p>
            <a href="/Proyecto/php_juego/escena.php?id=1" class="button-start">Comenzar Aventura</a>
            <p class="disclaimer fade-in-text">Tus decisiones serán registradas de forma anónima.</p>
        </div>  
    </main>
    <?php include 'FH/footer.php'; ?> 
    <script src="/Proyecto/script.js"></script>
</body>
</html>
