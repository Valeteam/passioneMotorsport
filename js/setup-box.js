/*
  setup-box.js
  ------------
  apriSetup ora e' asincrona perche' loadSetupData() fa una vera
  richiesta al server.
*/

const setupModal = document.getElementById('setup-modal');
const setupModalTitolo = document.getElementById('setup-modal-titolo');
const setupModalBody = document.getElementById('setup-modal-body');
const setupModalClose = document.getElementById('setup-modal-close');

function formattaValore(campo) {
    if (campo.value === null || campo.value === undefined) {
        return '—';
    }
    const numero = Number(campo.value).toLocaleString('it-IT', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 3
    });
    return campo.unit ? `${numero} ${campo.unit}` : numero;
}

function costruisciTabella(dati) {
    let righe = '';

    for (const gruppo in dati) {
        righe += `<tr class="setup-gruppo-riga"><td colspan="2">${gruppo}</td></tr>`;
        dati[gruppo].forEach(campo => {
            righe += `
                <tr>
                    <td class="setup-nome">${campo.label}</td>
                    <td class="setup-valore">${formattaValore(campo)}</td>
                </tr>
            `;
        });
    }

    return `<table class="setup-tabella"><tbody>${righe}</tbody></table>`;
}

async function apriSetup(garaId, garaNome) {
    setupModalTitolo.textContent = garaNome;
    setupModalBody.innerHTML = '<p style="color:var(--line); padding:20px 0;">caricamento...</p>';
    setupModal.classList.add('open');

    const dati = await loadSetupData(garaId);
    setupModalBody.innerHTML = costruisciTabella(dati);
}

function chiudiSetup() {
    setupModal.classList.remove('open');
}

document.querySelectorAll('.race-ticket').forEach(bottone => {
    bottone.addEventListener('click', () => {
        apriSetup(bottone.dataset.garaId, bottone.dataset.garaNome);
    });
});

setupModalClose.addEventListener('click', chiudiSetup);

setupModal.addEventListener('click', (e) => {
    if (e.target === setupModal) chiudiSetup();
});
