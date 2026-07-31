let activeId = null;

function statusClass(stato) {
    if (stato === 'da leggere') return 'status-unread';
    if (stato === 'risposto') return 'status-replied';
    return 'status-read';
}

function formatDate(iso) {
    const d = new Date(iso);
    return d.toLocaleDateString('it-IT', { day: 'numeric', month: 'short', year: 'numeric' });
}

async function loadCandidacies() {
    const candidature = await AdminDB.getAll('candidature');
    const tbody = document.getElementById('cand-table-body');
    const empty = document.getElementById('cand-empty');

    if (candidature.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = candidature.map(c => `
    <tr class="${c.stato === 'da leggere' ? 'unread' : ''}">
      <td>${c.nome}</td>
      <td><span class="tag dept-${c.reparto}">${c.reparto}</span></td>
      <td>${formatDate(c.creato_il)}</td>
      <td><span class="tag ${statusClass(c.stato)}">${c.stato}</span></td>
      <td class="actions">
        <button class="btn small" onclick="openModal(${c.id})">apri</button>
        <button class="btn small danger" onclick="deleteCandidacy(${c.id})">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function openModal(id) {
    const candidature = await AdminDB.getAll('candidature');
    const item = candidature.find(c => c.id === id);
    if (!item) return;

    activeId = id;
    document.getElementById('modal-nome').textContent = item.nome;
    document.getElementById('modal-email').textContent = item.email;
    document.getElementById('modal-reparto').textContent = item.reparto;
    document.getElementById('modal-reparto').className = `tag dept-${item.reparto}`;
    document.getElementById('modal-esperienza').textContent = item.esperienza;
    document.getElementById('cand-modal').classList.add('open');

    if (item.stato === 'da leggere') {
        await AdminDB.update('candidature', id, { stato: 'letto' });
        loadCandidacies();
    }
}

function closeCandModal() {
    document.getElementById('cand-modal').classList.remove('open');
    activeId = null;
}

async function markReplied() {
    if (!activeId) return;
    await AdminDB.update('candidature', activeId, { stato: 'risposto' });
    closeCandModal();
    loadCandidacies();
}

async function deleteCandidacy(id) {
    if (!confirm('Eliminare questa candidatura?')) return;
    await AdminDB.remove('candidature', id);
    loadCandidacies();
}

loadCandidacies();