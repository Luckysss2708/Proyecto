document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const title = container.querySelector('h1'); // Asegurarse de seleccionar dentro del contenedor
    const paragraphs = container.querySelectorAll('p:not(.disclaimer)'); // Seleccionar todos los p excepto el disclaimer
    const optionsDiv = container.querySelector('.options'); // El div que contiene los botones
    const disclaimer = container.querySelector('.disclaimer'); // El disclaimer
    
    // Si el contenedor ya tiene la clase 'show' (lo cual debería ser en tus escenas)
    // entonces animamos sus hijos inmediatamente.
    // Esto es crucial para las páginas de las escenas.

    // Animamos el título
    if (title) { // Verifica si el título existe
        title.style.opacity = 0;
        title.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            title.style.opacity = 1;
            title.style.transform = 'translateY(0)';
        }, 300); // Pequeño retraso para que el título aparezca
    }

    // Animamos los párrafos secuencialmente
    paragraphs.forEach((p, index) => {
        p.style.opacity = 0;
        p.style.transform = 'translateY(10px)';
        setTimeout(() => {
            p.style.opacity = 1;
            p.style.transform = 'translateY(0)';
        }, 600 + (index * 150)); // Cada párrafo aparece con un retraso de 150ms
    });

    // Anima los botones dentro de .options
    if (optionsDiv) {
        const buttons = optionsDiv.querySelectorAll('.button-start');
        buttons.forEach((button, index) => {
            button.style.opacity = 0;
            button.style.transform = 'scale(0.8)';
            setTimeout(() => {
                button.style.opacity = 1;
                button.style.transform = 'scale(1)';
            }, 600 + (paragraphs.length * 150) + (index * 100)); // Aparecen después de los párrafos con un pequeño retraso entre ellos
        });
    }

    // Anima el disclaimer
    if (disclaimer) {
        disclaimer.style.opacity = 0;
        disclaimer.style.transform = 'translateY(10px)';
        setTimeout(() => {
            disclaimer.style.opacity = 1;
            disclaimer.style.transform = 'translateY(0)';
        }, 600 + (paragraphs.length * 150) + (optionsDiv ? optionsDiv.querySelectorAll('.button-start').length * 100 : 0) + 200); // Aparece al final
    }
});