const garaForm = document.getElementById('gara-form');
const categoriaField = document.getElementById('gara-categoria');
const nomeField = document.getElementById('gara-nome');
const tbody = document.getElementById('gare-table-body');

const valoriPanel = document.getElementById('valori-panel');
const valoriHeading = document.getElementById('valori-heading');
const valoriContainer = document.getElementById('valori-container');
const valoriForm = document.getElementById('valori-form');
const valoriAnnulla = document.getElementById('valori-annulla');

let garaAttivaId = null;

async function loadCategorieOptions() {
    const categorie = await AdminDB.getAll('setupCategorie');
    categoriaField.innerHTML = categorie.map(c => `<option value="${Number(c.id)}">${esc(c.nome)}</option>`).join('');
}

async function loadGare() {
    const gare = await AdminDB.getAll('setupGare');
    const empty = document.getElementById('gare-empty');

    if (gare.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    // il nome della gara NON finisce dentro un onclick: sta in un attributo data-*
    // (un apice nel nome, es. "Rally dell'Elba", non rompe piu' niente)
    tbody.innerHTML = gare.map(g => `
        <tr>
            <td>${esc(g.categoria_nome)}</td>
            <td>${esc(g.nome)}</td>
            <td class="actions">
                <button class="btn small" data-azione="compila" data-id="${Number(g.id)}" data-titolo="${esc(g.categoria_nome + ' — ' + g.nome)}">compila valori</button>
                <button class="btn small danger" data-azione="elimina" data-id="${Number(g.id)}">elimina</button>
            </td>
        </tr>
    `).join('');
}

garaForm.addEventListener('submit', e => {
    e.preventDefault();

    conErrori(async () => {
        await AdminDB.add('setupGare', {
            categoria_id: Number(categoriaField.value),
            nome: nomeField.value
        });

        garaForm.reset();
        await loadGare();
        mostraMessaggio('Gara creata', 'ok');
    });
});

async function eliminaGara(id) {
    if (!confirm('Eliminare questa gara e tutti i suoi valori di setup?')) return;
    await AdminDB.remove('setupGare', id);
    await loadGare();
}

// ---------- compilazione valori ----------

async function compilaValori(garaId, nomeVisualizzato) {
    garaAttivaId = garaId;

    const parametri = await AdminDB.getConParametri('setupValori', { gara: garaId });

    valoriHeading.textContent = 'compila setup — ' + nomeVisualizzato;

    let html = '';
    let gruppoCorrente = null;

    parametri.forEach(p => {
        if (p.gruppo !== gruppoCorrente) {
            gruppoCorrente = p.gruppo;
            html += `<h4 style="margin:24px 0 12px; color:var(--accent); text-transform:uppercase; font-size:13px;">${esc(gruppoCorrente)}</h4>`;
        }

        const unitaLabel = p.unita ? ` (${esc(p.unita)})` : '';
        const valoreAttuale = p.valore !== null ? esc(p.valore) : '';

        html += `
            <div class="admin-field">
                <label for="param-${Number(p.id)}">${esc(p.etichetta)}${unitaLabel}</label>
                <input type="number" step="any" id="param-${Number(p.id)}" data-parametro-id="${Number(p.id)}" value="${valoreAttuale}">
            </div>
        `;
    });

    valoriContainer.innerHTML = html;
    valoriPanel.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

tbody.addEventListener('click', e => {
    const bottone = e.target.closest('button[data-azione]');
    if (!bottone) return;
    const id = Number(bottone.dataset.id);

    if (bottone.dataset.azione === 'compila') conErrori(() => compilaValori(id, bottone.dataset.titolo));
    if (bottone.dataset.azione === 'elimina') conErrori(() => eliminaGara(id));
});

valoriForm.addEventListener('submit', e => {
    e.preventDefault();

    conErrori(async () => {
        const inputs = valoriContainer.querySelectorAll('input[data-parametro-id]');
        const valori = Array.from(inputs).map(input => ({
            parametro_id: Number(input.dataset.parametroId),
            valore: input.value
        }));

        // il pannello si chiude SOLO se il salvataggio e' riuscito
        await AdminDB.put('setupValori', { gara_id: garaAttivaId, valori });

        valoriPanel.style.display = 'none';
        garaAttivaId = null;
        mostraMessaggio('Valori salvati', 'ok');
    });
});

valoriAnnulla.addEventListener('click', () => {
    valoriPanel.style.display = 'none';
    garaAttivaId = null;
});

conErrori(async () => {
    await loadCategorieOptions();
    await loadGare();
});
