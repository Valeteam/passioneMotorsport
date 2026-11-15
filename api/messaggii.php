<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("SELECT * FROM messaggi ORDER BY creato_il DESC")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            INSERT INTO messaggi (nome, email, motivo, messaggio, stato)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            campoTesto($dati, 'nome', 100),
            campoEmail($dati, 'email'),
            campoTesto($dati, 'motivo', 100),
            campoTesto($dati, 'messaggio', 5000),
            isset($dati['stato']) ? campoScelta($dati, 'stato', STATI_LETTURA) : 'da leggere'
        ]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("UPDATE messaggi SET stato = ? WHERE id = ?");
        $stmt->execute([
            campoScelta($dati, 'stato', STATI_LETTURA),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Messaggio non trovato');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM messaggi WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Messaggio non trovato');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
