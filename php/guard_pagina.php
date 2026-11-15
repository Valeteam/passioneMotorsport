<?php
/*
    guard_pagina.php
    ----------------
    Come auth.php ma per le PAGINE: invece di un errore JSON, fa un redirect.
    Ritorna il ruolo dell'utente cosi' la pagina puo' mostrarlo.
*/

function proteggiPagina(array $ruoliAmmessi, string $urlLogin, string $urlSeNonAmmesso): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');

    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . $urlLogin);
        exit;
    }

    $ruolo = $_SESSION['ruolo'] ?? '';

    if (!in_array($ruolo, $ruoliAmmessi, true)) {
        header('Location: ' . $urlSeNonAmmesso);
        exit;
    }

    return $ruolo;
}
