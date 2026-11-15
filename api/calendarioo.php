<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("SELECT * FROM calendario ORDER BY datazione ASC")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            INSERT INTO calendario (titolo, validita, datazione, immagine)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            campoTesto($dati, 'titolo', 150),
            campoScelta($dati, 'validita', ['moderno', 'storico']),
            campoData($dati, 'datazione'),
            campoImmagine($dati, 'immagine', 'calendario')
        ]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            UPDATE calendario
            SET titolo = ?, validita = ?, datazione = ?, immagine = ?
            WHERE id = ?
        ");
        $stmt->execute([
            campoTesto($dati, 'titolo', 150),
            campoScelta($dati, 'validita', ['moderno', 'storico']),
            campoData($dati, 'datazione'),
            campoImmagine($dati, 'immagine', 'calendario'),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Gara non trovata');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM calendario WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Gara non trovata');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
