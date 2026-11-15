<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("
            SELECT news.*, categorie.nome AS categoria
            FROM news
            LEFT JOIN categorie ON news.categoria_id = categorie.id
            ORDER BY data_pubblicazione DESC
        ")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            INSERT INTO news (titolo, descrizione, categoria_id, immagine, in_evidenza, data_pubblicazione)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            campoTesto($dati, 'titolo', 150),
            campoTesto($dati, 'descrizione', 20000),
            campoIntero($dati, 'categoria_id', false),
            campoImmagine($dati, 'immagine', 'news'),
            campoBool($dati, 'in_evidenza'),
            campoData($dati, 'data_pubblicazione')
        ]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            UPDATE news
            SET titolo = ?, descrizione = ?, categoria_id = ?, immagine = ?, in_evidenza = ?, data_pubblicazione = ?
            WHERE id = ?
        ");
        $stmt->execute([
            campoTesto($dati, 'titolo', 150),
            campoTesto($dati, 'descrizione', 20000),
            campoIntero($dati, 'categoria_id', false),
            campoImmagine($dati, 'immagine', 'news'),
            campoBool($dati, 'in_evidenza'),
            campoData($dati, 'data_pubblicazione'),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Articolo non trovato');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Articolo non trovato');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
