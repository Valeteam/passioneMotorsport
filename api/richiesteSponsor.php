<?php
header('Content-Type: application/json');
require_once '../php/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        $stmt = $pdo->query("SELECT * FROM richieste_sponsor ORDER BY creato_il DESC ");
        $risultati = $stmt->fetchAll();
        echo json_encode($risultati);
        break;

    case 'POST':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            INSERT INTO richieste_sponsor (azienda, referente, email, messaggio, stato)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $dati['azienda'],
            $dati['referente'],
            $dati['email'],
            $dati['messaggio'],
            $dati['stato']
        ]);

        echo json_encode(['id' => $pdo->lastInsertId(), 'successo' => true]);
        break;

    case 'PUT':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            UPDATE richieste_sponsor
            SET azienda = ?, referente = ?, email = ?, messaggio = ?, stato = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $dati['azienda'],
            $dati['referente'],
            $dati['email'],
            $dati['messaggio'],
            $dati['stato'],
            $dati['id']
        ]);

        echo json_encode(['successo' => true]);
        break;

    case 'DELETE':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("DELETE FROM richieste_sponsor WHERE id = ?");
        $stmt->execute([$dati['id']]);

        echo json_encode(['successo' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['errore' => 'Metodo non consentito']);
}

?>