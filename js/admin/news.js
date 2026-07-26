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
// quando ci sara' il backend, qui invece si fara' l'upload vero del file
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
    categoryField.innerHTML = categorie.map(c => `<option value="${c.nome}">${c.nome}</option>`).join('');
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
      <td>${item.title}</td>
      <td><span class="tag status-planned">${item.category}</span></td>
      <td>${formatDate(item.date)}</td>
      <td>${item.featured ? 'sì' : 'no'}</td>
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
    const item = news.find(n => n.id === id);
    if (!item) return;

    idField.value = item.id;
    titleField.value = item.title;
    excerptField.value = item.excerpt;
    categoryField.value = item.category;
    dateField.value = item.date;
    featuredField.checked = !!item.featured;

    if (item.image) {
        currentImageData = item.image;
        previewImg.src = item.image;
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
        title: titleField.value,
        excerpt: excerptField.value,
        category: categoryField.value,
        date: dateField.value,
        image: currentImageData,
        featured: featuredField.checked
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