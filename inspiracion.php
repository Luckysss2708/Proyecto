<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¿De qué nos inspiramos? - Código Roto</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/index.css">
    <style>
        .inspiration-image {
            max-width: 300px;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .images-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            margin-top: 30px;
        }
        .image-caption {
            text-align: center;
            font-style: italic;
            margin-top: 8px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header>
        <img src="imagenes/logocole.png" alt="Logo de la escuela">
        <nav>
            <a href="inspiracion.php">¿De qué nos inspiramos?</a>
            <a href="quien_soy.php">¿Quién soy?</a>
            <a href="escena.php?id=1">Comenzar Aventura</a>
        </nav>
    </header>

    <main class="container show">
        <h1>¿De qué nos inspiramos?</h1>
        <p>
            El proyecto <strong>Código Roto</strong> surge de la combinación de varias influencias que me parecieron interesantes y atractivas.
            Principalmente, está inspirado en los libros famosos de <em>"Elige tu propia aventura"</em>, que permiten al lector tomar decisiones
            que cambian el curso de la historia y crean múltiples finales posibles.
        </p>
        <p>
            Además, tomé mucha inspiración del juego <strong>Trolley Inc</strong>, que explora dilemas morales profundos basados en el famoso 
            dilema del tranvía, una temática que quise trasladar a un formato web interactivo y accesible.
        </p>

        <div class="images-container">
            <div>
                <img src="imagenes/elige_tu_aventura.jpg" alt="Libros Elige tu propia aventura" class="inspiration-image">
                <div class="image-caption">Libros "Elige tu propia aventura"</div>
            </div>
            <div>
                <img src="imagenes/trolley_inc.jpg" alt="Juego Trolley Inc" class="inspiration-image">
                <div class="image-caption">Juego "Trolley Inc"</div>
            </div>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
