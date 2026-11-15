<?php
/*
    auth.php
    --------
    Solo funzioni: ogni API sceglie quale chiamare in cima al file.
    richiediStaff()  -> admin e manager
    richiediTeam()   -> admin, manager e membro (qualsiasi utente del team)
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const RUOLI_STAFF = ['admin', 'manager'];
const RUOLI_TEAM  = ['admin', 'manager', 'membro'];

function rispondiAuth(int $codice, string $messaggio): void
{
    http_response_code($codice);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['errore' => $messaggio]);
    exit;
}

// 401 = "non so chi sei"
function richiediLogin(): void
{
    if (!isset($_SESSION['user_id'])) {
        rispondiAuth(401, 'Non autenticato');
    }
}

// 403 = "so chi sei, ma non puoi"
function richiediRuolo(array $ruoliAmmessi): void
{
    richiediLogin();

    $ruolo = $_SESSION['ruolo'] ?? '';

    if (!in_array($ruolo, $ruoliAmmessi, true)) {
        rispondiAuth(403, 'Permesso negato');
    }
}

function richiediStaff(): void
{
    richiediRuolo(RUOLI_STAFF);
}

function richiediTeam(): void
{
    richiediRuolo(RUOLI_TEAM);
}
