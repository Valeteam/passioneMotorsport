<?php
header('Content-Type: application/json');
require_once '../php/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        $stmt = $pdo->query("
            SELECT news.*, categorie.nome AS categoria
            FROM news
            LEFT JOIN categorie ON news.categoria_id = categorie.id
            ORDER BY data_pubblicazione DESC
        ");
        $risultati = $stmt->fetchAll();
        echo json_encode($risultati);
        break;

    case 'POST':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            INSERT INTO news (titolo, descrizione, categoria_id, immagine, in_evidenza, data_pubblicazione)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $dati['titolo'],
            $dati['descrizione'],
            $dati['categoria_id'],
            $dati['immagine'] ?? null,
            $dati['in_evidenza'] ?? false,
            $dati['data_pubblicazione']
        ]);

        echo json_encode(['id' => $pdo->lastInsertId(), 'successo' => true]);
        break;

    case 'PUT':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            UPDATE news
            SET titolo = ?, descrizione = ?, categoria_id = ?, immagine = ?, in_evidenza = ?, data_pubblicazione = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $dati['titolo'],
            $dati['descrizione'],
            $dati['categoria_id'],
            $dati['immagine'] ?? null,
            $dati['in_evidenza'] ?? false,
            $dati['data_pubblicazione'],
            $dati['id']
        ]);

        echo json_encode(['successo' => true]);
        break;

    case 'DELETE':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        $stmt->execute([$dati['id']]);

        echo json_encode(['successo' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['errore' => 'Metodo non consentito']);
}

?>