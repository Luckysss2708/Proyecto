document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const title = document.querySelector('h1');
    const paragraphs = document.querySelectorAll('p.fade-in-text');
    const button = document.querySelector('.button-start');
    const disclaimer = document.querySelector('.disclaimer');

    // Añade la clase 'show' al contenedor después de un breve retraso
    // para activar la animación de entrada del contenedor.
    setTimeout(() => {
        container.classList.add('show');

        // Luego, anima el título
        setTimeout(() => {
            title.style.opacity = 1;
            title.style.transform = 'translateY(0)';
        }, 500); // Aparece 0.5s después del contenedor

        // Anima los párrafos secuencialmente
        paragraphs.forEach((p, index) => {
            setTimeout(() => {
                p.style.opacity = 1;
                p.style.transform = 'translateY(0)';
            }, 800 + (index * 200)); // Cada párrafo aparece con un retraso de 200ms
        });

        // Anima el botón
        setTimeout(() => {
            button.style.opacity = 1;
            button.style.transform = 'scale(1)';
        }, 800 + (paragraphs.length * 200) + 300); // Aparece después de los párrafos + un extra

        // Anima el disclaimer
        setTimeout(() => {
            disclaimer.style.opacity = 1;
            disclaimer.style.transform = 'translateY(0)';
        }, 800 + (paragraphs.length * 200) + 600); // Aparece después del botón
        
    }, 100); // Retraso inicial para que la página cargue un poco
});