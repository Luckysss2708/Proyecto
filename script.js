function responder(opcion, escenaId) {
    fetch('guardar_respuesta.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            escena: escenaId,
            opcion: opcion
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById("resultado").innerText =
            `Opción A: ${data.a}% — Opción B: ${data.b}%`;
    });
}
