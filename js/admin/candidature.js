let activeId = null;

const tbody = document.getElementById('cand-table-body');

async function loadCandidacies() {
    const candidature = await AdminDB.getAll('candidature');
    const empty = document.getElementById('cand-empty');

    if (candidature.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = candidature.map(c => `
    <tr class="${c.stato === 'da leggere' ? 'unread' : ''}">
      <td>${esc(c.nome)}</td>
      <td><span class="tag dept-${esc(c.reparto)}">${esc(c.reparto)}</span></td>
      <td>${esc(formatDate(c.creato_il))}</td>
      <td><span class="tag ${statoClass(c.stato)}">${esc(c.stato)}</span></td>
      <td class="actions">
        <button class="btn small" data-azione="apri" data-id="${Number(c.id)}">apri</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(c.id)}">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function openModal(id) {
    const candidature = await AdminDB.getAll('candidature');
    const item = candidature.find(c => Number(c.id) === id);
    if (!item) return;

    activeId = id;
    // textContent = testo semplice, mai interpretato come HTML
    document.getElementById('modal-nome').textContent = item.nome;
    document.getElementById('modal-email').textContent = item.email;
    document.getElementById('modal-reparto').textContent = item.reparto;
    document.getElementById('modal-reparto').className = `tag dept-${item.reparto}`;
    document.getElementById('modal-esperienza').textContent = item.esperienza;
    document.getElementById('cand-modal').classList.add('open');

    if (item.stato === 'da leggere') {
        await AdminDB.update('candidature', id, { stato: 'letto' });
        await loadCandidacies();
        aggiornaBadge();
    }
}

function closeCandModal() {
    document.getElementById('cand-modal').classList.remove('open');
    activeId = null;
}

async function markReplied() {
    if (!activeId) return;
    const id = activeId;

    await conErrori(async () => {
        await AdminDB.update('candidature', id, { stato: 'risposto' });
        closeCandModal();
        await loadCandidacies();
        aggiornaBadge();
    });
}

async function deleteCandidacy(id) {
    if (!confirm('Eliminare questa candidatura?')) return;
    await AdminDB.remove('candidature', id);
    await loadCandidacies();
    aggiornaBadge();
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'apri') conErrori(() => openModal(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteCandidacy(id));
});

conErrori(loadCandidacies);
