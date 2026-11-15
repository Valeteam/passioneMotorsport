const form = document.getElementById('race-form');
const idField = document.getElementById('race-id');
const titoloField = document.getElementById('race-titolo');
const dataField = document.getElementById('race-data');
const validitaField = document.getElementById('race-validita');
const immagineField = document.getElementById('race-immagine');
const previewWrap = document.getElementById('upload-preview');
const previewImg = document.getElementById('upload-preview-img');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');
const tbody = document.getElementById('race-table-body');

let immagineCorrente = '';

collegaAnteprima(immagineField, previewWrap, previewImg);

function resetForm() {
    form.reset();
    idField.value = '';
    immagineCorrente = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuova gara';
    cancelBtn.style.display = 'none';
}

async function loadRaces() {
    const gare = await AdminDB.getAll('calendario');
    const empty = document.getElementById('race-empty');

    if (gare.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = gare.map(g => `
    <tr>
      <td>${esc(formatDate(g.datazione))}</td>
      <td>${esc(g.titolo)}</td>
      <td><span class="tag ${g.validita === 'storico' ? 'status-planned' : 'status-next'}">${esc(g.validita)}</span></td>
      <td class="actions">
        <button class="btn small" data-azione="modifica" data-id="${Number(g.id)}">modifica</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(g.id)}">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function editRace(id) {
    const gare = await AdminDB.getAll('calendario');
    const item = gare.find(g => Number(g.id) === id);
    if (!item) return;

    idField.value = item.id;
    titoloField.value = item.titolo;
    dataField.value = item.datazione;
    validitaField.value = item.validita;
    immagineCorrente = item.immagine || '';

    if (immagineCorrente) {
        previewImg.src = urlImmagine(immagineCorrente);
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }

    formHeading.textContent = 'modifica gara';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteRace(id) {
    if (!confirm('Rimuovere questa gara dal calendario?')) return;
    await AdminDB.remove('calendario', id);
    await loadRaces();
}

// un solo ascoltatore per tutta la tabella (niente onclick dentro l'HTML)
tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'modifica') conErrori(() => editRace(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteRace(id));
});

cancelBtn.addEventListener('click', resetForm);

form.addEventListener('submit', e => {
    e.preventDefault();

    conErrori(async () => {
        let percorso = immagineCorrente;
        const nuovoFile = immagineField.files[0];
        if (nuovoFile) {
            percorso = await AdminDB.upload('calendario', nuovoFile);
        }

        const payload = {
            titolo: titoloField.value,
            datazione: dataField.value,
            validita: validitaField.value,
            immagine: percorso || null
        };

        if (idField.value) {
            await AdminDB.update('calendario', Number(idField.value), payload);
        } else {
            await AdminDB.add('calendario', payload);
        }

        resetForm();
        await loadRaces();
        mostraMessaggio('Gara salvata', 'ok');
    });
});

conErrori(loadRaces);
