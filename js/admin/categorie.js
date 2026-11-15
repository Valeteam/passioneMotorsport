const form = document.getElementById('cat-form');
const idField = document.getElementById('cat-id');
const nomeField = document.getElementById('cat-nome');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');
const tbody = document.getElementById('cat-table-body');

function resetForm() {
    form.reset();
    idField.value = '';
    formHeading.textContent = 'nuova categoria';
    cancelBtn.style.display = 'none';
}

async function loadCategories() {
    const categorie = await AdminDB.getAll('categorie');
    const empty = document.getElementById('cat-empty');

    if (categorie.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = categorie.map(c => `
    <tr>
      <td>${esc(c.nome)}</td>
      <td class="actions">
        <button class="btn small" data-azione="modifica" data-id="${Number(c.id)}">rinomina</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(c.id)}">elimina</button>
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
    if (!confirm('Eliminare questa categoria? Gli articoli che la usano restano, ma rimarranno senza categoria.')) return;
    await AdminDB.remove('categorie', id);
    await loadCategories();
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'modifica') conErrori(() => editCategory(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteCategory(id));
});

cancelBtn.addEventListener('click', resetForm);

form.addEventListener('submit', e => {
    e.preventDefault();

    conErrori(async () => {
        const payload = { nome: nomeField.value.trim().toLowerCase() };

        if (idField.value) {
            await AdminDB.update('categorie', Number(idField.value), payload);
        } else {
            await AdminDB.add('categorie', payload);
        }

        resetForm();
        await loadCategories();
        mostraMessaggio('Categoria salvata', 'ok');
    });
});

conErrori(loadCategories);
