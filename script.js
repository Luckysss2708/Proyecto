// --- Función para responder ---
function responder(opcion, escenaId) {
    // Bloqueamos los botones mientras se procesa
    const botones = document.querySelectorAll(".opciones button");
    botones.forEach(btn => btn.disabled = true);

    fetch("guardar_respuesta.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            escena: escenaId,
            opcion: opcion
        })
    })
    .then(res => {
        if (!res.ok) throw new Error("Error de red");
        return res.json();
    })
    .then(data => {
        if (data.error) {
            document.getElementById("resultado").innerText = `⚠️ Error: ${data.error}`;
            botones.forEach(btn => btn.disabled = false);
            return;
        }

        // Mostrar resultados
        document.getElementById("resultado").classList.add("resultado-visible");
        document.getElementById("resultado").innerText =
            `Resultados: Opción A: ${data.a}% — Opción B: ${data.b}%`;

        // Redirigir si hay siguiente escena
        if (data.siguiente) {
            setTimeout(() => {
                window.location.href = `escena.php?id=${data.siguiente}`;
            }, 2500);
        } else {
            // Si no hay siguiente → Final alcanzado
            setTimeout(() => {
                window.location.href = "final.php";
            }, 2500);
        }
    })
    .catch(err => {
        console.error("Error:", err);
        document.getElementById("resultado").innerText = "❌ Error en la conexión.";
        botones.forEach(btn => btn.disabled = false);
    });
}

// --- Dropdown del usuario ---
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
