<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("SELECT * FROM richieste_sponsor ORDER BY creato_il DESC")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            INSERT INTO richieste_sponsor (azienda, referente, email, messaggio, stato)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            campoTesto($dati, 'azienda', 150),
            campoTesto($dati, 'referente', 100),
            campoEmail($dati, 'email'),
            campoTesto($dati, 'messaggio', 5000),
            isset($dati['stato']) ? campoScelta($dati, 'stato', STATI_LETTURA) : 'da leggere'
        ]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("UPDATE richieste_sponsor SET stato = ? WHERE id = ?");
        $stmt->execute([
            campoScelta($dati, 'stato', STATI_LETTURA),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Richiesta non trovata');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM richieste_sponsor WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Richiesta non trovata');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
