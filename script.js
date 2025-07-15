document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const optionsDiv = document.getElementById('game-options'); // Asegúrate de que tu div de opciones tenga este ID

    // Función para cargar el estado del juego
    function loadGameState() {
        try {
            const savedState = localStorage.getItem('dilemasGameState');
            return savedState ? JSON.parse(savedState) : {
                currentScene: 'escena1',
                decisionPath: [],
                moralScore: {
                    utilitarian: 0,
                    deontological: 0,
                    compassion: 0 // Añade si usas esta categoría
                }
            };
        } catch (e) {
            console.error("Error al cargar el estado del juego:", e);
            return {
                currentScene: 'escena1',
                decisionPath: [],
                moralScore: {
                    utilitarian: 0,
                    deontological: 0,
                    compassion: 0
                }
            };
        }
    }

    // Función para guardar el estado del juego
    function saveGameState(state) {
        try {
            localStorage.setItem('dilemasGameState', JSON.stringify(state));
        } catch (e) {
            console.error("Error al guardar el estado del juego:", e);
        }
    }

    // Lógica para el botón de "Comenzar/Continuar Aventura" en la página principal
    // Esta lógica solo debe ejecutarse si estás en la "portada" (index.php sin ID de escena)
    const urlParams = new URLSearchParams(window.location.search);
    const sceneIdFromUrl = urlParams.get('id');

    if (!sceneIdFromUrl) { // Estamos en la página de inicio sin una escena específica cargada
        const startButton = document.querySelector('a.button-start');
        if (startButton) {
            const gameState = loadGameState();
            if (gameState.decisionPath.length > 0 && gameState.currentScene && gameState.currentScene !== 'escena1') {
                startButton.textContent = 'Continuar Aventura';
                startButton.href = `index.php?id=${gameState.currentScene}`;

                const newGameButton = document.createElement('a');
                newGameButton.href = "javascript:void(0)"; // Evita que navegue
                newGameButton.textContent = 'Empezar Nueva Aventura';
                newGameButton.classList.add('button-start');
                newGameButton.style.marginTop = '20px';
                newGameButton.addEventListener('click', () => {
                    resetGame();
                    window.location.href = 'index.php?id=escena1';
                });
                startButton.parentNode.insertBefore(newGameButton, startButton.nextSibling);
            } else {
                startButton.href = 'index.php?id=escena1';
            }
        }
    }

    // Función para resetear el juego
    function resetGame() {
        localStorage.removeItem('dilemasGameState');
    }

    // Lógica principal para las opciones de la escena
    if (optionsDiv) {
        optionsDiv.addEventListener('click', async (event) => {
            const target = event.target.closest('.button-start'); // Usa closest para asegurar que es el <a>
            if (target) {
                event.preventDefault(); // Detiene la navegación inmediata

                const currentSceneId = target.dataset.currentSceneId;
                const optionIndex = target.dataset.optionIndex;
                const nextSceneHref = target.getAttribute('href'); // El href completo para la siguiente escena

                // --- Lógica para guardar la decisión y el impacto moral ---
                const decisionId = target.dataset.decisionId;
                const moralImpact = target.dataset.moralImpact;
                const moralValue = parseInt(target.dataset.moralValue || '0');

                let gameState = loadGameState();

                if (decisionId) {
                    gameState.decisionPath.push(decisionId);
                }
                if (moralImpact && !isNaN(moralValue)) {
                    if (gameState.moralScore[moralImpact] !== undefined) {
                        gameState.moralScore[moralImpact] += moralValue;
                    }
                }
                gameState.currentScene = nextSceneHref.split('=')[1]; // Guarda solo el ID de la siguiente escena
                saveGameState(gameState);

                // --- Lógica para actualizar contadores y mostrar porcentajes ---
                try {
                    const response = await fetch('update_choice.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `scene_id=${encodeURIComponent(currentSceneId)}&option_index=${encodeURIComponent(optionIndex)}`
                    });

                    const data = await response.json();

                    if (data.success) {
                        const totalPlays = data.plays.opcion1_plays + data.plays.opcion2_plays;

                        // Mostrar porcentajes si hay suficientes datos
                        if (totalPlays > 0) {
                            const percent1 = (data.plays.opcion1_plays / totalPlays) * 100;
                            const percent2 = (data.plays.opcion2_plays / totalPlays) * 100;

                            document.getElementById('percentage-1').textContent = `(${percent1.toFixed(0)}%)`;
                            document.getElementById('percentage-2').textContent = `(${percent2.toFixed(0)}%)`;

                            optionsDiv.classList.add('show-percentages'); // Muestra los spans de porcentaje
                        }
                    } else {
                        console.error('Error al actualizar contadores:', data.message);
                    }
                } catch (error) {
                    console.error('Error de red al actualizar contadores:', error);
                }

                // Pequeño retraso para que el usuario vea los porcentajes antes de navegar
                setTimeout(() => {
                    container.classList.remove('show');
                    container.classList.add('hide');
                    setTimeout(() => {
                        window.location.href = nextSceneHref; // Navega a la siguiente escena
                    }, 500); // Coincide con la duración de la transición CSS
                }, 1500); // Retraso para ver los porcentajes (1.5 segundos)
            }
        });
    }
});