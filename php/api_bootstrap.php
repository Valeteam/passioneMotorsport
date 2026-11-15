<?php
/*
    api_bootstrap.php
    -----------------
    Da includere in cima a OGNI file in api/:
        require_once __DIR__ . '/../php/api_bootstrap.php';
    Fa: header JSON, niente warning a schermo (rovinerebbero il JSON),
    connessione al DB, funzioni di auth, gestione centrale degli errori
    e le funzioni per leggere e validare i dati in arrivo.
*/

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';

function rispondi(array $dati, int $codice = 200): void
{
    http_response_code($codice);
    echo json_encode($dati);
    exit;
}

function errore(int $codice, string $messaggio): void
{
    rispondi(['errore' => $messaggio], $codice);
}

set_exception_handler(function (Throwable $e) {
    error_log((string) $e);

    if ($e instanceof PDOException) {
        $codiceSql = (int) ($e->errorInfo[1] ?? 0);

        if ($codiceSql === 1062) {
            errore(409, 'Esiste già un elemento con questo valore');
        }
        if ($codiceSql === 1451) {
            errore(409, 'Elemento in uso: non può essere eliminato');
        }
        if ($codiceSql === 1452) {
            errore(400, 'Riferimento non valido (elemento collegato inesistente)');
        }
    }

    errore(500, 'Errore interno del server');
});

// ---------- lettura e validazione dei dati ----------

function leggiBody(): array
{
    $dati = json_decode(file_get_contents('php://input'), true);

    if (!is_array($dati)) {
        errore(400, 'Corpo della richiesta mancante o non valido');
    }

    return $dati;
}

function campoTesto(array $dati, string $campo, int $max, bool $obbligatorio = true): ?string
{
    $valore = $dati[$campo] ?? null;

    if ($valore === null || (is_string($valore) && trim($valore) === '')) {
        if ($obbligatorio) {
            errore(400, "Campo '$campo' obbligatorio");
        }
        return null;
    }

    if (!is_string($valore)) {
        errore(400, "Campo '$campo' non valido");
    }

    $valore = trim($valore);

    if (mb_strlen($valore) > $max) {
        errore(400, "Campo '$campo' troppo lungo (massimo $max caratteri)");
    }

    return $valore;
}

function campoIntero(array $dati, string $campo, bool $obbligatorio = true): ?int
{
    $valore = $dati[$campo] ?? null;

    if ($valore === null || $valore === '') {
        if ($obbligatorio) {
            errore(400, "Campo '$campo' obbligatorio");
        }
        return null;
    }

    $intero = filter_var($valore, FILTER_VALIDATE_INT);

    if ($intero === false) {
        errore(400, "Campo '$campo' non valido");
    }

    return $intero;
}

function campoScelta(array $dati, string $campo, array $ammessi): string
{
    $valore = $dati[$campo] ?? null;

    if (!is_string($valore) || !in_array($valore, $ammessi, true)) {
        errore(400, "Campo '$campo' non valido");
    }

    return $valore;
}

function campoEmail(array $dati, string $campo, int $max = 150): string
{
    $valore = campoTesto($dati, $campo, $max);

    if (!filter_var($valore, FILTER_VALIDATE_EMAIL)) {
        errore(400, "Campo '$campo' non è un'email valida");
    }

    return $valore;
}

function campoData(array $dati, string $campo): string
{
    $valore = $dati[$campo] ?? null;

    if (!is_string($valore)) {
        errore(400, "Campo '$campo' obbligatorio");
    }

    $data = DateTime::createFromFormat('Y-m-d', $valore);

    if (!$data || $data->format('Y-m-d') !== $valore) {
        errore(400, "Campo '$campo' non è una data valida (AAAA-MM-GG)");
    }

    return $valore;
}

function campoBool(array $dati, string $campo): int
{
    $valore = filter_var($dati[$campo] ?? false, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    return $valore ? 1 : 0;
}

function campoImmagine(array $dati, string $campo, string $cartella): ?string
{
    $valore = campoTesto($dati, $campo, 255, false);

    if ($valore === null) {
        return null;
    }

    $schema = '#^assets/img/' . preg_quote($cartella, '#') . '/[A-Za-z0-9._-]+\.(jpe?g|png|webp|gif)$#i';

    if (!preg_match($schema, $valore)) {
        errore(400, "Campo '$campo' non è un percorso immagine valido");
    }

    return $valore;
}

const STATI_LETTURA = ['da leggere', 'letto', 'risposto'];
