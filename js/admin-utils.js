/*
    admin-utils.js
    --------------
    Funzioni comuni a tutte le pagine admin. Va caricato PRIMA di admin-storage.js
    e degli script delle singole pagine.
*/

function esc(valore) {
    return String(valore ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
}

function formatDate(iso, mese = 'short') {
    if (!iso) return '—';
    const d = new Date(iso);
    if (isNaN(d)) return '—';
    return d.toLocaleDateString('it-IT', { day: 'numeric', month: mese, year: 'numeric' });
}

function statoClass(stato) {
    if (stato === 'da leggere') return 'status-unread';
    if (stato === 'risposto') return 'status-replied';
    return 'status-read';
}

function urlImmagine(percorso) {
    return percorso ? '../../' + percorso : '';
}

function mostraMessaggio(testo, tipo = 'errore') {
    let box = document.getElementById('admin-toast');
    if (!box) {
        box = document.createElement('div');
        box.id = 'admin-toast';
        box.setAttribute('role', 'status');
        document.body.appendChild(box);
    }
    const voce = document.createElement('div');
    voce.className = 'admin-toast-item ' + tipo;
    voce.textContent = testo;
    box.appendChild(voce);
    setTimeout(() => voce.remove(), 5000);
}

function gestisciErrore(err) {
    console.error(err);
    mostraMessaggio(err && err.message ? err.message : 'Errore imprevisto');
}

async function conErrori(funzione) {
    try {
        return await funzione();
    } catch (err) {
        gestisciErrore(err);
    }
}

function collegaAnteprima(input, wrap, img) {
    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            wrap.style.display = 'block';
        };
        reader.readAsDataURL(file);
    });
}
