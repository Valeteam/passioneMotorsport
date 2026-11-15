const form = document.getElementById('news-form');
const idField = document.getElementById('news-id');
const titleField = document.getElementById('news-title');
const excerptField = document.getElementById('news-excerpt');
const categoryField = document.getElementById('news-category');
const dateField = document.getElementById('news-date');
const imageField = document.getElementById('news-image');
const featuredField = document.getElementById('news-featured');
const previewWrap = document.getElementById('upload-preview');
const previewImg = document.getElementById('upload-preview-img');
const cancelBtn = document.getElementById('cancel-edit');
const formHeading = document.getElementById('form-heading');
const tbody = document.getElementById('news-table-body');

// percorso dell'immagine GIA' salvata (quello che sta nel database)
let immagineCorrente = '';

collegaAnteprima(imageField, previewWrap, previewImg);

function resetForm() {
    form.reset();
    idField.value = '';
    immagineCorrente = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuovo articolo';
    cancelBtn.style.display = 'none';
}

async function loadCategoryOptions() {
    const categorie = await AdminDB.getAll('categorie');
    categoryField.innerHTML = categorie.map(c => `<option value="${Number(c.id)}">${esc(c.nome)}</option>`).join('');
}

async function loadNewsTable() {
    const news = await AdminDB.getAll('news');
    const empty = document.getElementById('news-empty');

    if (news.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = news.map(item => `
    <tr>
      <td>${esc(item.titolo)}</td>
      <td><span class="tag status-planned">${esc(item.categoria ?? '—')}</span></td>
      <td>${esc(formatDate(item.data_pubblicazione, 'long'))}</td>
      <td>${Number(item.in_evidenza) ? 'sì' : 'no'}</td>
      <td class="actions">
        <button class="btn small" data-azione="modifica" data-id="${Number(item.id)}">modifica</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(item.id)}">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function editNews(id) {
    const news = await AdminDB.getAll('news');
    const item = news.find(n => Number(n.id) === id);
    if (!item) return;

    idField.value = item.id;
    titleField.value = item.titolo;
    excerptField.value = item.descrizione;
    categoryField.value = item.categoria_id;
    dateField.value = item.data_pubblicazione;
    featuredField.checked = !!Number(item.in_evidenza);
    imageField.value = '';

    immagineCorrente = item.immagine || '';
    if (immagineCorrente) {
        previewImg.src = urlImmagine(immagineCorrente);
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }

    formHeading.textContent = 'modifica articolo';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteNews(id) {
    if (!confirm('Eliminare questo articolo?')) return;
    await AdminDB.remove('news', id);
    await loadNewsTable();
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'modifica') conErrori(() => editNews(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteNews(id));
});

cancelBtn.addEventListener('click', resetForm);

form.addEventListener('submit', e => {
    e.preventDefault();

    conErrori(async () => {
        let percorso = immagineCorrente;
        const nuovoFile = imageField.files[0];
        if (nuovoFile) {
            percorso = await AdminDB.upload('news', nuovoFile);
        }

        const payload = {
            titolo: titleField.value,
            descrizione: excerptField.value,
            categoria_id: Number(categoryField.value) || null,
            data_pubblicazione: dateField.value,
            immagine: percorso || null,
            in_evidenza: featuredField.checked
        };

        if (idField.value) {
            await AdminDB.update('news', Number(idField.value), payload);
        } else {
            await AdminDB.add('news', payload);
        }

        resetForm();
        await loadNewsTable();
        mostraMessaggio('Articolo salvato', 'ok');
    });
});

conErrori(async () => {
    await loadCategoryOptions();
    await loadNewsTable();
});
