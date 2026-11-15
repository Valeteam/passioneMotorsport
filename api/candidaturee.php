<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("SELECT * FROM candidature ORDER BY creato_il DESC")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            INSERT INTO candidature (nome, email, reparto, esperienza, stato)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            campoTesto($dati, 'nome', 100),
            campoEmail($dati, 'email'),
            campoScelta($dati, 'reparto', ['esports', 'reale']),
            campoTesto($dati, 'esperienza', 5000),
            isset($dati['stato']) ? campoScelta($dati, 'stato', STATI_LETTURA) : 'da leggere'
        ]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        // dal pannello si cambia solo lo stato (letto / risposto)
        $dati = leggiBody();

        $stmt = $pdo->prepare("UPDATE candidature SET stato = ? WHERE id = ?");
        $stmt->execute([
            campoScelta($dati, 'stato', STATI_LETTURA),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Candidatura non trovata');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM candidature WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Candidatura non trovata');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
