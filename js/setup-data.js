/*
    setup-data.js (TeamPage)
    ------------------------
    loadSetupData() chiede al server i valori di QUELLA gara specifica.
    Il percorso e' relativo alla pagina (pages/TeamPage.php -> ../api/).
*/

async function loadSetupData(garaId) {
    const risposta = await fetch(`../api/setup_valori.php?gara=${encodeURIComponent(garaId)}`, {
        credentials: 'same-origin'
    });

    if (!risposta.ok) {
        throw new Error(risposta.status === 403 || risposta.status === 401
            ? 'Non hai i permessi per vedere questo setup'
            : 'Impossibile caricare il setup');
    }

    const parametri = await risposta.json();

    const raggruppati = {};
    parametri.forEach(p => {
        if (!raggruppati[p.gruppo]) raggruppati[p.gruppo] = [];
        raggruppati[p.gruppo].push({
            label: p.etichetta,
            value: p.valore,
            unit: p.unita ?? ''
        });
    });

    return raggruppati;
}
