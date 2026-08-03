/*
  admin-storage.js
  -----------------
  Livello dati condiviso per tutto il pannello admin.
  Per ora salva tutto in localStorage (persiste solo su questo browser),
  ma ogni funzione ritorna una Promise: quando ci sarà il backend PHP,
  basterà sostituire il corpo di ogni funzione con una fetch() verso
  l'API, senza cambiare il codice delle pagine che le usano.

  Esempio di come sarà DOPO (PHP + MySQL):

    function getAll(collection) {
      return fetch(`/api/${collection}.php`).then(r => r.json());
    }

  Per ora invece leggiamo/scriviamo su localStorage.
*/

const AdminDB = (() => {

    function _key(collection) {
        return `pmt_admin_${collection}`;
    }

    function _read(collection) {
        const raw = localStorage.getItem(_key(collection));
        return raw ? JSON.parse(raw) : null;
    }

    function _write(collection, data) {
        localStorage.setItem(_key(collection), JSON.stringify(data));
    }

    // dati di esempio: solo la prima volta che si apre l'admin,
    // cosi' le pagine non sono vuote durante lo sviluppo
    const seedData = {
        news: [
            { id: 1, title: "Vittoria al Rally Sardegna online", excerpt: "Marco Volante chiude in testa la tappa speciale della WRC eSports Series.", category: "gare", date: "2026-07-20", image: "", featured: true },
            { id: 2, title: "Test su strada in vista del rally regionale", excerpt: "Giornata di prove per Sara Ferri e Luca Rossetti sul percorso ufficiale.", category: "gare", date: "2026-07-08", image: "", featured: false },
            { id: 3, title: "Nuovo accordo con sponsor tecnico", excerpt: "OfficinaTech entra come fornitore ufficiale di componenti.", category: "annunci", date: "2026-07-01", image: "", featured: false }
        ],
        categorie: [
            { id: 1, nome: "gare" },
            { id: 2, nome: "community" },
            { id: 3, nome: "annunci" }
        ],
        calendario: [
            { id: 1, nome: "Rally Sardegna online — finale", reparto: "esports", data: "2026-07-10", stato: "disputata" },
            { id: 2, nome: "Rally del Titano", reparto: "reale", data: "2026-08-02", stato: "prossima" },
            { id: 3, nome: "EA Sports WRC League — tappa 1", reparto: "esports", data: "2026-08-16", stato: "in programma" }
        ],
        sponsor: [
            { id: 1, nome: "OfficinaTech", livello: "official partner", logo: "" },
            { id: 2, nome: "ApexTires", livello: "tech partner", logo: "" }
        ],
        richiesteSponsor: [
            { id: 1, azienda: "MotorParts SRL", referente: "Anna Bianchi", email: "anna@motorparts.it", messaggio: "Interessati alla sponsorizzazione tier partner ufficiale.", data: "2026-07-18", stato: "da leggere" }
        ],
        messaggi: [
            { id: 1, nome: "Luigi Verdi", email: "luigi.verdi@email.it", motivo: "collaborazione media", messaggio: "Vorrei proporre una collaborazione per un servizio fotografico.", data: "2026-07-19", stato: "da leggere" }
        ],
        candidature: [
            { id: 1, nome: "Federico Neri", email: "federico.neri@email.it", reparto: "esports", esperienza: "3 anni su iRacing, campionato regionale amatoriale.", data: "2026-07-17", stato: "da leggere" }
        ]
    };

    function _ensureSeeded(collection) {
        const existing = _read(collection);
        if (existing === null) {
            _write(collection, seedData[collection] || []);
        }
    }

    function _nextId(list) {
        return list.length ? Math.max(...list.map(i => i.id)) + 1 : 1;
    }

    // ---------- API pubblica ----------

    function getAll(collection) {
        _ensureSeeded(collection);
        return Promise.resolve(_read(collection));
    }

    function add(collection, item) {
        _ensureSeeded(collection);
        const list = _read(collection);
        const newItem = { ...item, id: _nextId(list) };
        list.unshift(newItem);
        _write(collection, list);
        return Promise.resolve(newItem);
    }

    function update(collection, id, changes) {
        _ensureSeeded(collection);
        const list = _read(collection);
        const idx = list.findIndex(i => i.id === id);
        if (idx === -1) return Promise.reject(new Error("elemento non trovato"));
        list[idx] = { ...list[idx], ...changes };
        _write(collection, list);
        return Promise.resolve(list[idx]);
    }

    function remove(collection, id) {
        _ensureSeeded(collection);
        const list = _read(collection).filter(i => i.id !== id);
        _write(collection, list);
        return Promise.resolve(true);
    }

    return { getAll, add, update, remove };
})();