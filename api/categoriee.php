<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("SELECT * FROM categorie ORDER BY nome ASC")->fetchAll());

    case 'POST':
        $dati = leggiBody();

        $stmt = $pdo->prepare("INSERT INTO categorie (nome) VALUES (?)");
        $stmt->execute([campoTesto($dati, 'nome', 50)]);

        rispondi(['id' => (int) $pdo->lastInsertId(), 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("UPDATE categorie SET nome = ? WHERE id = ?");
        $stmt->execute([
            campoTesto($dati, 'nome', 50),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Categoria non trovata');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Categoria non trovata');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
