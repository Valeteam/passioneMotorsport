const form = document.getElementById('pilota-form');
const idField = document.getElementById('pilota-id');
const nomeSelezionato = document.getElementById('pilota-nome-selezionato');
const categoriaField = document.getElementById('pilota-categoria');
const posizioneField = document.getElementById('pilota-posizione');
const fotoField = document.getElementById('pilota-foto');
const previewWrap = document.getElementById('upload-preview');
const previewImg = document.getElementById('upload-preview-img');
const saveBtn = document.getElementById('save-btn');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');
const tbody = document.getElementById('piloti-table-body');

let fotoCorrente = '';

collegaAnteprima(fotoField, previewWrap, previewImg);

function resetForm() {
    form.reset();
    idField.value = '';
    fotoCorrente = '';
    previewWrap.style.display = 'none';
    nomeSelezionato.textContent = 'nessuno selezionato';
    formHeading.textContent = 'seleziona un pilota dalla tabella per modificarlo';
    saveBtn.disabled = true;
    cancelBtn.style.display = 'none';
}

async function loadPiloti() {
    const piloti = await AdminDB.getAll('piloti');
    const empty = document.getElementById('piloti-empty');

    if (piloti.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = piloti.map(p => `
    <tr>
      <td>${p.foto_profilo ? `<img src="${esc(urlImmagine(p.foto_profilo))}" alt="" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">` : '—'}</td>
      <td>${esc(p.username)}</td>
      <td>${esc(p.categoria ?? '—')}</td>
      <td>${esc(p.ultima_posizione ?? '—')}</td>
      <td class="actions">
        <button class="btn small" data-azione="modifica" data-id="${Number(p.id)}">modifica</button>
      </td>
    </tr>
  `).join('');
}

async function selectPilota(id) {
    const piloti = await AdminDB.getAll('piloti');
    const item = piloti.find(p => Number(p.id) === id);
    if (!item) return;

    idField.value = item.id;
    nomeSelezionato.textContent = item.username;
    categoriaField.value = item.categoria ?? '';
    posizioneField.value = item.ultima_posizione ?? '';
    fotoField.value = '';
    fotoCorrente = item.foto_profilo ?? '';

    if (fotoCorrente) {
        previewImg.src = urlImmagine(fotoCorrente);
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }

    formHeading.textContent = 'modifica: ' + item.username;
    saveBtn.disabled = false;
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    conErrori(() => selectPilota(Number(bottone.dataset.id)));
});

cancelBtn.addEventListener('click', resetForm);

form.addEventListener('submit', e => {
    e.preventDefault();
    if (!idField.value) return;

    conErrori(async () => {
        let percorso = fotoCorrente;
        const nuovoFile = fotoField.files[0];
        if (nuovoFile) {
            percorso = await AdminDB.upload('piloti', nuovoFile);
        }

        await AdminDB.update('piloti', Number(idField.value), {
            categoria: categoriaField.value || null,
            ultima_posizione: posizioneField.value || null,
            foto_profilo: percorso || null
        });

        resetForm();
        await loadPiloti();
        mostraMessaggio('Pilota aggiornato', 'ok');
    });
});

conErrori(loadPiloti);
