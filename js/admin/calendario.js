const form = document.getElementById('race-form');
const idField = document.getElementById('race-id');
const nomeField = document.getElementById('race-nome');
const repartoField = document.getElementById('race-reparto');
const dataField = document.getElementById('race-data');
const statoField = document.getElementById('race-stato');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');

function statusClass(stato) {
    if (stato === 'disputata') return 'status-done';
    if (stato === 'prossima') return 'status-next';
    return 'status-planned';
}

async function loadRaces() {
    let gare = await AdminDB.getAll('calendario');
    gare = [...gare].sort((a, b) => new Date(a.data) - new Date(b.data));

    const tbody = document.getElementById('race-table-body');
    const empty = document.getElementById('race-empty');

    if (gare.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = gare.map(g => `
    <tr>
      <td>${formatDate(g.data)}</td>
      <td>${g.nome}</td>
      <td><span class="tag dept-${g.reparto}">${g.reparto}</span></td>
      <td><span class="tag ${statusClass(g.stato)}">${g.stato}</span></td>
      <td class="actions">
        <button class="btn small" onclick="editRace(${g.id})">modifica</button>
        <button class="btn small danger" onclick="deleteRace(${g.id})">elimina</button>
      </td>
    </tr>
  `).join('');
}

function formatDate(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('it-IT', { day: 'numeric', month: 'short', year: 'numeric' });
}

async function editRace(id) {
    const gare = await AdminDB.getAll('calendario');
    const item = gare.find(g => g.id === id);
    if (!item) return;

    idField.value = item.id;
    nomeField.value = item.nome;
    repartoField.value = item.reparto;
    dataField.value = item.data;
    statoField.value = item.stato;

    formHeading.textContent = 'modifica gara';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteRace(id) {
    if (!confirm('Rimuovere questa gara dal calendario?')) return;
    await AdminDB.remove('calendario', id);
    loadRaces();
}

cancelBtn.addEventListener('click', () => {
    form.reset();
    idField.value = '';
    formHeading.textContent = 'nuova gara';
    cancelBtn.style.display = 'none';
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
        nome: nomeField.value,
        reparto: repartoField.value,
        data: dataField.value,
        stato: statoField.value
    };

    if (idField.value) {
        await AdminDB.update('calendario', Number(idField.value), payload);
    } else {
        await AdminDB.add('calendario', payload);
    }

    form.reset();
    idField.value = '';
    formHeading.textContent = 'nuova gara';
    cancelBtn.style.display = 'none';

    loadRaces();
});

loadRaces();