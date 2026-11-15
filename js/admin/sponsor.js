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
const tbody = document.getElementById('sponsor-table-body');

let logoCorrente = '';

collegaAnteprima(logoField, previewWrap, previewImg);

function resetForm() {
    form.reset();
    idField.value = '';
    logoCorrente = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuovo sponsor';
    cancelBtn.style.display = 'none';
}

async function loadSponsors() {
    const sponsor = await AdminDB.getAll('sponsor');
    const empty = document.getElementById('sponsor-empty');

    if (sponsor.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = sponsor.map(s => `
    <tr>
      <td>${esc(s.nome)}</td>
      <td><span class="tag status-planned">${esc(s.livello)}</span></td>
      <td class="actions">
        <button class="btn small" data-azione="modifica" data-id="${Number(s.id)}">modifica</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(s.id)}">rimuovi</button>
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
    logoField.value = '';

    logoCorrente = item.logo || '';
    if (logoCorrente) {
        previewImg.src = urlImmagine(logoCorrente);
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }

    formHeading.textContent = 'modifica sponsor';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteSponsor(id) {
    if (!confirm('Rimuovere questo sponsor?')) return;
    await AdminDB.remove('sponsor', id);
    await loadSponsors();
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'modifica') conErrori(() => editSponsor(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteSponsor(id));
});

cancelBtn.addEventListener('click', resetForm);

form.addEventListener('submit', e => {
    e.preventDefault();

    conErrori(async () => {
        let percorso = logoCorrente;
        const nuovoFile = logoField.files[0];
        if (nuovoFile) {
            percorso = await AdminDB.upload('sponsor', nuovoFile);
        }

        const payload = {
            nome: nomeField.value,
            livello: livelloField.value,
            logo: percorso || null
        };

        if (idField.value) {
            await AdminDB.update('sponsor', Number(idField.value), payload);
        } else {
            await AdminDB.add('sponsor', payload);
        }

        resetForm();
        await loadSponsors();
        mostraMessaggio('Sponsor salvato', 'ok');
    });
});

/* ---------- richieste di sponsorizzazione ---------- */
let activeRequestId = null;

const requestsBody = document.getElementById('requests-table-body');

async function loadRequests() {
    const richieste = await AdminDB.getAll('richiesteSponsor');
    const empty = document.getElementById('requests-empty');

    if (richieste.length === 0) {
        requestsBody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    requestsBody.innerHTML = richieste.map(r => `
    <tr class="${r.stato === 'da leggere' ? 'unread' : ''}">
      <td>${esc(r.azienda)}</td>
      <td>${esc(r.referente)}</td>
      <td>${esc(formatDate(r.creato_il))}</td>
      <td><span class="tag ${statoClass(r.stato)}">${esc(r.stato)}</span></td>
      <td class="actions">
        <button class="btn small" data-azione="apri" data-id="${Number(r.id)}">apri</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(r.id)}">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function openRequestModal(id) {
    const richieste = await AdminDB.getAll('richiesteSponsor');
    const item = richieste.find(r => Number(r.id) === id);
    if (!item) return;

    activeRequestId = id;
    // textContent = testo semplice, mai interpretato come HTML
    document.getElementById('modal-azienda').textContent = item.azienda;
    document.getElementById('modal-referente').textContent = `${item.referente} — ${item.email}`;
    document.getElementById('modal-messaggio').textContent = item.messaggio;
    document.getElementById('request-modal').classList.add('open');

    if (item.stato === 'da leggere') {
        await AdminDB.update('richiesteSponsor', id, { stato: 'letto' });
        await loadRequests();
    }
}

function closeRequestModal() {
    document.getElementById('request-modal').classList.remove('open');
    activeRequestId = null;
}

async function markRequestReplied() {
    if (!activeRequestId) return;
    const id = activeRequestId;

    await conErrori(async () => {
        await AdminDB.update('richiesteSponsor', id, { stato: 'risposto' });
        closeRequestModal();
        await loadRequests();
    });
}

async function deleteRequest(id) {
    if (!confirm('Eliminare questa richiesta?')) return;
    await AdminDB.remove('richiesteSponsor', id);
    await loadRequests();
}

requestsBody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'apri') conErrori(() => openRequestModal(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteRequest(id));
});

conErrori(loadSponsors);
conErrori(loadRequests);
