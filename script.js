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

document.addEventListener("DOMContentLoaded", function () {
  const userButton = document.getElementById("user-button");
  const userDropdown = document.getElementById("user-dropdown");

  if (userButton && userDropdown) {
    userButton.addEventListener("click", function (e) {
      e.stopPropagation();
      userDropdown.classList.toggle("hidden");
    });

    document.addEventListener("click", function (e) {
      if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.add("hidden");
      }
    });

    userDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }
});

