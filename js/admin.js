async function loadDashboard() {
    const stats = await AdminDB.getAll('stats');

    document.getElementById('stat-news').textContent = stats.totali.news;
    document.getElementById('stat-gare').textContent = stats.totali.gare;
    document.getElementById('stat-messaggi').textContent = stats.da_leggere.messaggi;
    document.getElementById('stat-candidature').textContent = stats.da_leggere.candidature;
}

conErrori(loadDashboard);
