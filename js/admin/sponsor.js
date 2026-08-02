/* ---------- sponsor attivi ---------- */
const form = document.getElementById('sponsor-form');
const idField = document.getElementById('sponsor-id');
const nomeField = document.getElementById('sponsor-nome');
const livelloField = document.getElementById('sponsor-livello');
const logoField = document.getElementById('sponsor-logo');
const previewWrap = document.getElementById('upload-preview');
const previewImg = document.getElementById('upload-preview-img');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');

let currentLogoData = "";

logoField.addEventListener('change', () => {
    const file = logoField.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        currentLogoData = e.target.result;
        previewImg.src = currentLogoData;
        previewWrap.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

async function loadSponsors() {
    const sponsor = await AdminDB.getAll('sponsor');
    const tbody = document.getElementById('sponsor-table-body');
    const empty = document.getElementById('sponsor-empty');

    if (sponsor.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = sponsor.map(s => `
    <tr>
      <td>${s.nome}</td>
      <td><span class="tag status-planned">${s.livello}</span></td>
      <td class="actions">
        <button class="btn small" onclick="editSponsor(${s.id})">modifica</button>
        <button class="btn small danger" onclick="deleteSponsor(${s.id})">rimuovi</button>
      </td>
    </tr>
  `).join('');
}

async function editSponsor(id) {
    const sponsor = await AdminDB.getAll('sponsor');
    const item = sponsor.find(s => Number(s.id) === id);
    if (!item) return;

    idField.value = item.id;
    nomeField.value = item.nome;
    livelloField.value = item.livello;

    if (item.logo) {
        currentLogoData = item.logo;
        previewImg.src = item.logo;
        previewWrap.style.display = 'block';
    }

    formHeading.textContent = 'modifica sponsor';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteSponsor(id) {
    if (!confirm('Rimuovere questo sponsor?')) return;
    await AdminDB.remove('sponsor', id);
    loadSponsors();
}

cancelBtn.addEventListener('click', () => {
    form.reset();
    idField.value = '';
    currentLogoData = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuovo sponsor';
    cancelBtn.style.display = 'none';
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    let percorsoImmagine = currentLogoData;
    const nuovoFile = logoField.files[0];
    if (nuovoFile) {
        percorsoImmagine = await uploadImage(nuovoFile);
    }

    const payload = {
        nome: nomeField.value,
        livello: livelloField.value,
        logo: percorsoImmagine
    };

    if (idField.value) {
        await AdminDB.update('sponsor', Number(idField.value), payload);
    } else {
        await AdminDB.add('sponsor', payload);
    }

    form.reset();
    idField.value = '';
    currentLogoData = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuovo sponsor';
    cancelBtn.style.display = 'none';

    loadSponsors();
});

async function uploadImage(file) {
    const dati = new FormData();
    dati.append('tipo', 'sponsor');
    dati.append('immagine', file);

    const risposta = await fetch(API_BASE + 'uploadImg.php', {
        method: 'POST',
        body: dati
    });

    const risultato = await risposta.json();
    return risultato.percorso;
}

/* ---------- richieste di sponsorizzazione ---------- */
let activeRequestId = null;

function requestStatusClass(stato) {
    if (stato === 'da leggere') return 'status-unread';
    if (stato === 'risposto') return 'status-replied';
    return 'status-read';
}

async function loadRequests() {
    const richieste = await AdminDB.getAll('richiesteSponsor');
    const tbody = document.getElementById('requests-table-body');
    const empty = document.getElementById('requests-empty');

    if (richieste.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = richieste.map(r => `
    <tr class="${r.stato === 'da leggere' ? 'unread' : ''}">
      <td>${r.azienda}</td>
      <td>${r.referente}</td>
      <td>${formatDate(r.creato_il)}</td>
      <td><span class="tag ${requestStatusClass(r.stato)}">${r.stato}</span></td>
      <td class="actions">
        <button class="btn small" onclick="openRequestModal(${r.id})">apri</button>
        <button class="btn small danger" onclick="deleteRequest(${r.id})">elimina</button>
      </td>
    </tr>
  `).join('');
}

function formatDate(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('it-IT', { day: 'numeric', month: 'short', year: 'numeric' });
}

async function openRequestModal(id) {
    const richieste = await AdminDB.getAll('richiesteSponsor');
    const item = richieste.find(r => Number(r.id) === id);
    if (!item) return;

    activeRequestId = id;
    document.getElementById('modal-azienda').textContent = item.azienda;
    document.getElementById('modal-referente').textContent = `${item.referente} — ${item.email}`;
    document.getElementById('modal-messaggio').textContent = item.messaggio;
    document.getElementById('request-modal').classList.add('open');

    if (item.stato === 'da leggere') {
        await AdminDB.update('richiesteSponsor', id, { stato: 'letto' });
        loadRequests();
    }
}

function closeRequestModal() {
    document.getElementById('request-modal').classList.remove('open');
    activeRequestId = null;
}

async function markRequestReplied() {
    if (!activeRequestId) return;
    await AdminDB.update('richiesteSponsor', activeRequestId, { stato: 'risposto' });
    closeRequestModal();
    loadRequests();
}

async function deleteRequest(id) {
    if (!confirm('Eliminare questa richiesta?')) return;
    await AdminDB.remove('richiesteSponsor', id);
    loadRequests();
}

loadSponsors();
loadRequests();