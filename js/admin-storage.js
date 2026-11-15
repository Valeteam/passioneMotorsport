/*
    admin-storage.js
    ----------------
    Livello dati dell'admin: tutte le chiamate alle API passano da qui.
    Richiede admin-utils.js caricato prima.
*/

const API_BASE = new URL('../api/', document.currentScript.src).href;

const ENDPOINT = {
    news: "newss.php",
    categorie: "categoriee.php",
    calendario: "calendarioo.php",
    sponsor: "sponsorAttivi.php",
    richiesteSponsor: "richiesteSponsor.php",
    messaggi: "messaggii.php",
    candidature: "candidaturee.php",
    piloti: "piloti.php",
    setupCategorie: "setup_categorie.php",
    setupGare: "setup_gare.php",
    setupValori: "setup_valori.php",
    stats: "stats.php"
};

const AdminDB = (() => {

    async function richiesta(url, opzioni = {}) {
        let r;
        try {
            r = await fetch(url, { credentials: 'same-origin', ...opzioni });
        } catch (e) {
            throw new Error('Server non raggiungibile');
        }

        let dati = null;
        try {
            dati = await r.json();
        } catch (e) {
            throw new Error('Risposta non valida dal server');
        }

        if (!r.ok) {
            if (r.status === 401) {
                window.location.href = new URL('../loginPage.php', API_BASE).href;
            }
            throw new Error((dati && dati.errore) || `Errore ${r.status}`);
        }

        return dati;
    }

    function conCorpo(metodo, corpo) {
        return {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(corpo)
        };
    }

    function getAll(collection) {
        return richiesta(API_BASE + ENDPOINT[collection]);
    }

    function getConParametri(collection, parametri) {
        const query = new URLSearchParams(parametri).toString();
        return richiesta(API_BASE + ENDPOINT[collection] + '?' + query);
    }

    function add(collection, item) {
        return richiesta(API_BASE + ENDPOINT[collection], conCorpo('POST', item));
    }

    function update(collection, id, changes) {
        return richiesta(API_BASE + ENDPOINT[collection], conCorpo('PUT', { ...changes, id: id }));
    }

    function put(collection, corpo) {
        return richiesta(API_BASE + ENDPOINT[collection], conCorpo('PUT', corpo));
    }

    function remove(collection, id) {
        return richiesta(API_BASE + ENDPOINT[collection], conCorpo('DELETE', { id: id }));
    }

    async function upload(tipo, file) {
        const dati = new FormData();
        dati.append('tipo', tipo);
        dati.append('immagine', file);

        const risultato = await richiesta(API_BASE + 'uploadImg.php', { method: 'POST', body: dati });

        if (!risultato.successo || !risultato.percorso) {
            throw new Error(risultato.errore || 'Upload non riuscito');
        }
        return risultato.percorso;
    }

    return { getAll, getConParametri, add, update, put, remove, upload };
})();
