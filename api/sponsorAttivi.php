<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

const LIVELLI_SPONSOR = ['supporter', 'official partner', 'tech partner'];

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("SELECT * FROM sponsor ORDER BY nome ASC")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("INSERT INTO sponsor (nome, livello, logo) VALUES (?, ?, ?)");
        $stmt->execute([
            campoTesto($dati, 'nome', 150),
            campoScelta($dati, 'livello', LIVELLI_SPONSOR),
            campoImmagine($dati, 'logo', 'sponsor')
        ]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("UPDATE sponsor SET nome = ?, livello = ?, logo = ? WHERE id = ?");
        $stmt->execute([
            campoTesto($dati, 'nome', 150),
            campoScelta($dati, 'livello', LIVELLI_SPONSOR),
            campoImmagine($dati, 'logo', 'sponsor'),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Sponsor non trovato');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM sponsor WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Sponsor non trovato');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
