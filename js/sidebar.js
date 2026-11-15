// Badge "da leggere" nella sidebar: una sola chiamata leggera a stats.php
// (prima scaricava tutti i messaggi e tutte le candidature solo per contarli).
// La funzione e' globale: le pagine la richiamano dopo aver letto/eliminato qualcosa.
async function aggiornaBadge() {
    try {
        const stats = await AdminDB.getAll('stats');
        impostaBadge('badge-messaggi', stats.da_leggere.messaggi);
        impostaBadge('badge-candidature', stats.da_leggere.candidature);
    } catch (err) {
        console.error(err);
    }
}

function impostaBadge(id, numero) {
    const badge = document.getElementById(id);
    if (!badge) return;
    badge.textContent = numero;
    badge.style.display = numero === 0 ? 'none' : '';
}

aggiornaBadge();


document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("adminSidebar");
    const toggle = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");

    if (!sidebar || !toggle || !overlay) {
        console.error("Sidebar: elementi non trovati");
        return;
    }

    function openSidebar() {
        sidebar.classList.add("open");
        toggle.classList.add("open");
        overlay.classList.add("open");
        document.body.style.overflow = "hidden";
    }

    function closeSidebar() {
        sidebar.classList.remove("open");
        toggle.classList.remove("open");
        overlay.classList.remove("open");
        document.body.style.overflow = "";
    }

    toggle.addEventListener("click", function () {
        if (sidebar.classList.contains("open")) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    overlay.addEventListener("click", closeSidebar);

    sidebar.querySelectorAll("a").forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });

});
