const garaForm = document.getElementById('gara-form');
const categoriaField = document.getElementById('gara-categoria');
const nomeField = document.getElementById('gara-nome');

const valoriPanel = document.getElementById('valori-panel');
const valoriHeading = document.getElementById('valori-heading');
const valoriContainer = document.getElementById('valori-container');
const valoriForm = document.getElementById('valori-form');
const valoriAnnulla = document.getElementById('valori-annulla');

let garaAttivaId = null;

async function loadCategorieOptions() {
    const categorie = await AdminDB.getAll('setupCategorie');
    categoriaField.innerHTML = categorie.map(c => `<option value="${c.id}">${c.nome}</option>`).join('');
}

async function loadGare() {
    const gare = await AdminDB.getAll('setupGare');
    const tbody = document.getElementById('gare-table-body');
    const empty = document.getElementById('gare-empty');

    if (gare.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = 'block';
        return;
    }
    empty.style.display = 'none';

    tbody.innerHTML = gare.map(g => `
        <tr>
            <td>${g.categoria_nome}</td>
            <td>${g.nome}</td>
            <td class="actions">
                <button class="btn small" onclick="compilaValori(${g.id}, '${g.categoria_nome} — ${g.nome}')">compila valori</button>
                <button class="btn small danger" onclick="eliminaGara(${g.id})">elimina</button>
            </td>
        </tr>
    `).join('');
}

garaForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    await AdminDB.add('setupGare', {
        categoria_id: Number(categoriaField.value),
        nome: nomeField.value
    });

    garaForm.reset();
    loadGare();
});

async function eliminaGara(id) {
    if (!confirm('Eliminare questa gara e tutti i suoi valori di setup?')) return;
    await AdminDB.remove('setupGare', id);
    loadGare();
}

// ---------- compilazione valori ----------
// setup_valori.php non segue lo schema standard delle altre API
// (GET vuole un parametro nell'url, PUT manda piu' valori insieme),
// quindi qui chiamiamo fetch() direttamente invece di passare da AdminDB

async function compilaValori(garaId, nomeVisualizzato) {
    garaAttivaId = garaId;

    const risposta = await fetch(API_BASE + `setup_valori.php?gara=${garaId}`);
    const parametri = await risposta.json();

    valoriHeading.textContent = 'compila setup — ' + nomeVisualizzato;

    let html = '';
    let gruppoCorrente = null;

    parametri.forEach(p => {
        if (p.gruppo !== gruppoCorrente) {
            gruppoCorrente = p.gruppo;
            html += `<h4 style="margin:24px 0 12px; color:var(--accent); text-transform:uppercase; font-size:13px;">${gruppoCorrente}</h4>`;
        }

        const unitaLabel = p.unita ? ` (${p.unita})` : '';
        const valoreAttuale = p.valore !== null ? p.valore : '';

        html += `
            <div class="admin-field">
                <label for="param-${p.id}">${p.etichetta}${unitaLabel}</label>
                <input type="number" step="any" id="param-${p.id}" data-parametro-id="${p.id}" value="${valoreAttuale}">
            </div>
        `;
    });

    valoriContainer.innerHTML = html;
    valoriPanel.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

valoriForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const inputs = valoriContainer.querySelectorAll('input[data-parametro-id]');
    const valori = Array.from(inputs).map(input => ({
        parametro_id: Number(input.dataset.parametroId),
        valore: input.value
    }));

    await fetch(API_BASE + 'setup_valori.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ gara_id: garaAttivaId, valori })
    });

    valoriPanel.style.display = 'none';
    garaAttivaId = null;
});

valoriAnnulla.addEventListener('click', () => {
    valoriPanel.style.display = 'none';
    garaAttivaId = null;
});

loadCategorieOptions();
loadGare();
