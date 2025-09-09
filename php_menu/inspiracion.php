<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿De qué nos inspiramos? - Código Roto</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/inspiracion.css">
</head>
<body>
    <?php
session_start();
?>
   <?php include '../FH/header.php'; ?>
    <main class="container">
    <h1 class="titulo-inspiracion">¿De qué me inspire?</h1>

    <div class="texto-inspiracion">
        <p>
            El proyecto <strong>Código Roto</strong> surge de la combinación de varias influencias que me parecieron interesantes y atractivas.
            Principalmente, está inspirado en los libros famosos de <em>"Elige tu propia aventura"</em>, que permiten al lector tomar decisiones
            que cambian el curso de la historia y crean múltiples finales posibles.
        </p>
        <p>
            Además, tomé mucha inspiración del juego <strong>Trolley Inc</strong>, que explora dilemas morales profundos basados en el famoso 
            dilema del tranvía, una temática que quise trasladar a un formato web interactivo y accesible.
        </p>
    </div>

    <div class="imagenes-flex">
        <div>
            <img src="../imagenes/elige_tu_aventura.jpg" alt="Libros Elige tu propia aventura" class="inspiration-image">
            <div class="image-caption">Libros "Elige tu propia aventura"</div>
        </div>
        <div>
            <img src="../imagenes/trolley_inc.jpg" alt="Juego Trolley Inc" class="inspiration-image">
            <div class="image-caption">Juego "Trolley Inc"</div>
        </div>
    </div>
</main>
<?php include '../FH/footer.php'; ?> 
    <script src="../script.js"></script>
</body>
</html>
