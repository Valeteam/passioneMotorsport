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