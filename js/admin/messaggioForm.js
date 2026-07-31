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

async function loadMessages() {
    const messaggi = await AdminDB.getAll('messaggi');
    const tbody = document.getElementById('msg-table-body');
    const empty = document.getElementById('msg-empty');

    if (messaggi.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = messaggi.map(m => `
    <tr class="${m.stato === 'da leggere' ? 'unread' : ''}">
      <td>${m.nome}</td>
      <td>${m.motivo}</td>
      <td>${formatDate(m.creato_il)}</td>
      <td><span class="tag ${statusClass(m.stato)}">${m.stato}</span></td>
      <td class="actions">
        <button class="btn small" onclick="openModal(${m.id})">apri</button>
        <button class="btn small danger" onclick="deleteMessage(${m.id})">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function openModal(id) {
    const messaggi = await AdminDB.getAll('messaggi');
    const item = messaggi.find(m => m.id === id);
    if (!item) return;

    activeId = id;
    document.getElementById('modal-nome').textContent = item.nome;
    document.getElementById('modal-email').textContent = item.email;
    document.getElementById('modal-motivo').textContent = item.motivo;
    document.getElementById('modal-testo').textContent = item.messaggio;
    document.getElementById('msg-modal').classList.add('open');

    if (item.stato === 'da leggere') {
        await AdminDB.update('messaggi', id, { stato: 'letto' });
        loadMessages();
    }
}

function closeMsgModal() {
    document.getElementById('msg-modal').classList.remove('open');
    activeId = null;
}

async function markReplied() {
    if (!activeId) return;
    await AdminDB.update('messaggi', activeId, { stato: 'risposto' });
    closeMsgModal();
    loadMessages();
}

async function deleteMessage(id) {
    if (!confirm('Eliminare questo messaggio?')) return;
    await AdminDB.remove('messaggi', id);
    loadMessages();
}

loadMessages();