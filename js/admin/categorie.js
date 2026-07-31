const form = document.getElementById('cat-form');
const idField = document.getElementById('cat-id');
const nomeField = document.getElementById('cat-nome');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');

async function loadCategories() {
    const categorie = await AdminDB.getAll('categorie');
    const tbody = document.getElementById('cat-table-body');
    const empty = document.getElementById('cat-empty');

    if (categorie.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = categorie.map(c => `
    <tr>
      <td>${c.nome}</td>
      <td class="actions">
        <button class="btn small" onclick="editCategory(${c.id})">rinomina</button>
        <button class="btn small danger" onclick="deleteCategory(${c.id})">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function editCategory(id) {
    const categorie = await AdminDB.getAll('categorie');
    const item = categorie.find(c => Number(c.id) === id);
    if (!item) return;

    idField.value = item.id;
    nomeField.value = item.nome;
    formHeading.textContent = 'rinomina categoria';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteCategory(id) {
    if (!confirm('Eliminare questa categoria? Gli articoli che la usano non verranno modificati.')) return;
    await AdminDB.remove('categorie', id);
    loadCategories();
}

cancelBtn.addEventListener('click', () => {
    form.reset();
    idField.value = '';
    formHeading.textContent = 'nuova categoria';
    cancelBtn.style.display = 'none';
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const payload = { nome: nomeField.value.trim().toLowerCase() };

    if (idField.value) {
        await AdminDB.update('categorie', Number(idField.value), payload);
    } else {
        await AdminDB.add('categorie', payload);
    }

    form.reset();
    idField.value = '';
    formHeading.textContent = 'nuova categoria';
    cancelBtn.style.display = 'none';

    loadCategories();
});

loadCategories();