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

let currentImageData = "";

// converte l'immagine caricata in base64 solo per l'anteprima locale.
// quando ci sara' l'upload vero (Fase 5), qui si fara' l'upload reale del file
// al server (FormData + fetch) e si salvera' il percorso restituito.
imageField.addEventListener('change', () => {
    const file = imageField.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        currentImageData = e.target.result;
        previewImg.src = currentImageData;
        previewWrap.style.display = 'block';
    };
    reader.readAsDataURL(file);
});

async function loadCategoryOptions() {
    const categorie = await AdminDB.getAll('categorie');
    // il value deve essere l'id (numero), perche' news.categoria_id nel database
    // e' una foreign key verso categorie.id, non il nome della categoria
    categoryField.innerHTML = categorie.map(c => `<option value="${c.id}">${c.nome}</option>`).join('');
}

async function loadNewsTable() {
    const news = await AdminDB.getAll('news');
    const tbody = document.getElementById('news-table-body');
    const empty = document.getElementById('news-empty');

    if (news.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = news.map(item => `
    <tr>
      <td>${item.titolo}</td>
      <td><span class="tag status-planned">${item.categoria ?? '—'}</span></td>
      <td>${formatDate(item.data_pubblicazione)}</td>
      <td>${Number(item.in_evidenza) ? 'sì' : 'no'}</td>
      <td class="actions">
        <button class="btn small" onclick="editNews(${item.id})">modifica</button>
        <button class="btn small danger" onclick="deleteNews(${item.id})">elimina</button>
      </td>
    </tr>
  `).join('');
}

function formatDate(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('it-IT', { day: 'numeric', month: 'long', year: 'numeric' });
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

    if (item.immagine) {
        currentImageData = item.immagine;
        previewImg.src = item.immagine;
        previewWrap.style.display = 'block';
    } else {
        currentImageData = "";
        previewWrap.style.display = 'none';
    }

    formHeading.textContent = 'modifica articolo';
    cancelBtn.style.display = 'inline-flex';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteNews(id) {
    if (!confirm('Eliminare questo articolo?')) return;
    await AdminDB.remove('news', id);
    loadNewsTable();
}

cancelBtn.addEventListener('click', () => {
    form.reset();
    idField.value = '';
    currentImageData = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuovo articolo';
    cancelBtn.style.display = 'none';
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const payload = {
        titolo: titleField.value,
        descrizione: excerptField.value,
        categoria_id: Number(categoryField.value),
        data_pubblicazione: dateField.value,
        immagine: currentImageData,
        in_evidenza: featuredField.checked
    };

    if (idField.value) {
        await AdminDB.update('news', Number(idField.value), payload);
    } else {
        await AdminDB.add('news', payload);
    }

    form.reset();
    idField.value = '';
    currentImageData = '';
    previewWrap.style.display = 'none';
    formHeading.textContent = 'nuovo articolo';
    cancelBtn.style.display = 'none';

    loadNewsTable();
});

loadCategoryOptions();
loadNewsTable();