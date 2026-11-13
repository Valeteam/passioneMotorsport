async function loadSidebarBadges() {
    const [messaggi, candidature] = await Promise.all([
        AdminDB.getAll('messaggi'),
        AdminDB.getAll('candidature')
    ]);

    const messaggiDaLeggere = messaggi.filter(m => m.stato === 'da leggere').length;
    const candidatureDaLeggere = candidature.filter(c => c.stato === 'da leggere').length;

    const badgeMessaggi = document.getElementById('badge-messaggi');
    const badgeCandidature = document.getElementById('badge-candidature');

    if (badgeMessaggi) {
        badgeMessaggi.textContent = messaggiDaLeggere;
        badgeMessaggi.style.display = messaggiDaLeggere === 0 ? 'none' : '';
    }

    if (badgeCandidature) {
        badgeCandidature.textContent = candidatureDaLeggere;
        badgeCandidature.style.display = candidatureDaLeggere === 0 ? 'none' : '';
    }
}

loadSidebarBadges();


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