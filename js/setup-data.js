/*
  setup-data.js (versione pubblica, collegata al backend)
  ---------------------------------------------------------
  Adesso loadSetupData() e' davvero asincrona: chiede al server
  i valori reali di QUELLA gara specifica.
*/

async function loadSetupData(garaId) {
    const risposta = await fetch(`../api/setup_valori.php?gara=${garaId}`);
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
