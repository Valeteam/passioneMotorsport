async function loadDashboard() {
            const [news, calendario, messaggi, candidature] = await Promise.all([
                AdminDB.getAll('news'),
                AdminDB.getAll('calendario'),
                AdminDB.getAll('messaggi'),
                AdminDB.getAll('candidature')
            ]);

            document.getElementById('stat-news').textContent = news.length;
            document.getElementById('stat-gare').textContent = calendario.length;

            const messaggiDaLeggere = messaggi.filter(m => m.stato === 'da leggere').length;
            const candidatureDaLeggere = candidature.filter(c => c.stato === 'da leggere').length;

            document.getElementById('stat-messaggi').textContent = messaggiDaLeggere;
            document.getElementById('stat-candidature').textContent = candidatureDaLeggere;

            document.getElementById('badge-messaggi').textContent = messaggiDaLeggere;
            document.getElementById('badge-candidature').textContent = candidatureDaLeggere;

            if (messaggiDaLeggere === 0) document.getElementById('badge-messaggi').style.display = 'none';
            if (candidatureDaLeggere === 0) document.getElementById('badge-candidature').style.display = 'none';
        }
        loadDashboard();