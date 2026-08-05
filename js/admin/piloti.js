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

let currentFotoPath = "";

fotoField.addEventListener('change', () => {
    const file = fotoField.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        previewImg.src = e.target.result;
        previewWrap.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

// stessa logica di upload gia' usata in news.js/sponsor.js, con tipo 'piloti'
async function uploadImage(file) {
    const dati = new FormData();
    dati.append('tipo', 'piloti');
    dati.append('immagine', file);

    const risposta = await fetch(API_BASE + 'uploadImg.php', {
        method: 'POST',
        body: dati
    });

    const risultato = await risposta.json();
    return risultato.percorso;
}

async function loadPiloti() {
    const piloti = await AdminDB.getAll('piloti');
    const tbody = document.getElementById('piloti-table-body');
    const empty = document.getElementById('piloti-empty');

    if (piloti.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = piloti.map(p => `
    <tr>
      <td>${p.foto_profilo ? `<img src="../../${p.foto_profilo}" alt="" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">` : '—'}</td>
      <td>${p.username}</td>
      <td>${p.categoria ?? '—'}</td>
      <td>${p.ultima_posizione ?? '—'}</td>
      <td class="actions">
        <button class="btn small" onclick="selectPilota(${p.id})">modifica</button>
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
    currentFotoPath = item.foto_profilo ?? '';

    if (currentFotoPath) {
        previewImg.src = '../../' + currentFotoPath;
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }

    formHeading.textContent = 'modifica: ' + item.username;
    saveBtn.disabled = false;
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    form.reset();
    idField.value = '';
    currentFotoPath = '';
    previewWrap.style.display = 'none';
    nomeSelezionato.textContent = 'nessuno selezionato';
    formHeading.textContent = 'seleziona un pilota dalla tabella per modificarlo';
    saveBtn.disabled = true;
    cancelBtn.style.display = 'none';
}

cancelBtn.addEventListener('click', resetForm);

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!idField.value) return;

    let percorsoFoto = currentFotoPath;
    const nuovoFile = fotoField.files[0];
    if (nuovoFile) {
        percorsoFoto = await uploadImage(nuovoFile);
    }

    const payload = {
        categoria: categoriaField.value || null,
        ultima_posizione: posizioneField.value || null,
        foto_profilo: percorsoFoto || null
    };

    await AdminDB.update('piloti', Number(idField.value), payload);

    resetForm();
    loadPiloti();
});

loadPiloti();
