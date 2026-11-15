let activeId = null;

const tbody = document.getElementById('msg-table-body');

async function loadMessages() {
    const messaggi = await AdminDB.getAll('messaggi');
    const empty = document.getElementById('msg-empty');

    if (messaggi.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = messaggi.map(m => `
    <tr class="${m.stato === 'da leggere' ? 'unread' : ''}">
      <td>${esc(m.nome)}</td>
      <td>${esc(m.motivo)}</td>
      <td>${esc(formatDate(m.creato_il))}</td>
      <td><span class="tag ${statoClass(m.stato)}">${esc(m.stato)}</span></td>
      <td class="actions">
        <button class="btn small" data-azione="apri" data-id="${Number(m.id)}">apri</button>
        <button class="btn small danger" data-azione="elimina" data-id="${Number(m.id)}">elimina</button>
      </td>
    </tr>
  `).join('');
}

async function openModal(id) {
    const messaggi = await AdminDB.getAll('messaggi');
    const item = messaggi.find(m => Number(m.id) === id);
    if (!item) return;

    activeId = id;
    // textContent = testo semplice, mai interpretato come HTML
    document.getElementById('modal-nome').textContent = item.nome;
    document.getElementById('modal-email').textContent = item.email;
    document.getElementById('modal-motivo').textContent = item.motivo;
    document.getElementById('modal-testo').textContent = item.messaggio;
    document.getElementById('msg-modal').classList.add('open');

    if (item.stato === 'da leggere') {
        await AdminDB.update('messaggi', id, { stato: 'letto' });
        await loadMessages();
        aggiornaBadge();
    }
}

function closeMsgModal() {
    document.getElementById('msg-modal').classList.remove('open');
    activeId = null;
}

async function markReplied() {
    if (!activeId) return;
    const id = activeId;

    await conErrori(async () => {
        await AdminDB.update('messaggi', id, { stato: 'risposto' });
        closeMsgModal();
        await loadMessages();
        aggiornaBadge();
    });
}

async function deleteMessage(id) {
    if (!confirm('Eliminare questo messaggio?')) return;
    await AdminDB.remove('messaggi', id);
    await loadMessages();
    aggiornaBadge();
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'apri') conErrori(() => openModal(id));
    if (bottone.dataset.azione === 'elimina') conErrori(() => deleteMessage(id));
});

conErrori(loadMessages);
