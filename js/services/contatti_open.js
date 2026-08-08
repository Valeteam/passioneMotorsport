const motivoField = document.getElementById('motivo');
const aziendaField = document.getElementById('azienda');
const repartoField = document.getElementById('reparto');

function nascondi(campo) {
    campo.style.display = 'none';
    campo.required = false;
    campo.value = '';
}

function mostra(campo, obbligatorio) {
    campo.style.display = '';
    campo.required = obbligatorio;
}

function aggiornaCampiMotivo() {
    const motivo = motivoField.value;

    if (motivo === 'candidatura') {
        nascondi(aziendaField);
        mostra(repartoField, true);
    } else if (motivo === 'sponsor') {
        mostra(aziendaField, true);
        nascondi(repartoField);
    } else {
        nascondi(aziendaField);
        nascondi(repartoField);
    }
}

motivoField.addEventListener('change', aggiornaCampiMotivo);

aggiornaCampiMotivo();