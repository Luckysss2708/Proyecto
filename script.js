function responder(opcion) {
    fetch('responder.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            escena: 1,
            opcion: opcion
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById("resultado").innerText =
            `Opción A: ${data.a}% — Opción B: ${data.b}%`;
    });
}
