document.addEventListener('DOMContentLoaded', () => {
    const optionsDiv = document.getElementById('game-options');

    if (optionsDiv) {
        optionsDiv.addEventListener('click', async (event) => {
            const target = event.target.closest('.button-start');
            if (target) {
                event.preventDefault();

                const currentSceneId = target.dataset.currentSceneId;
                const optionIndex = target.dataset.optionIndex;
                const nextSceneHref = target.getAttribute('href');

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
                        if (totalPlays > 0) {
                            const percent1 = (data.plays.opcion1_plays / totalPlays) * 100;
                            const percent2 = (data.plays.opcion2_plays / totalPlays) * 100;

                            document.getElementById('percentage-1').textContent = `${percent1.toFixed(0)}%`;
                            document.getElementById('percentage-2').textContent = `${percent2.toFixed(0)}%`;
                        }
                    } else {
                        console.error('Error al actualizar contadores:', data.message);
                    }
                } catch (error) {
                    console.error('Error de red al actualizar contadores:', error);
                }

                // Mostrar porcentajes un segundo antes de cambiar escena
                setTimeout(() => {
                    window.location.href = nextSceneHref;
                }, 1000);
            }
        });
    }
});
