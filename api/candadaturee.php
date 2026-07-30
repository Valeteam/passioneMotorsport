<?php
header('Content-Type: application/json');
require_once '../php/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        $stmt = $pdo->query("SELECT * FROM candidature ORDER BY stato ASC");
        $risultati = $stmt->fetchAll();
        echo json_encode($risultati);
        break;

    case 'POST':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            INSERT INTO candidature (nome, email, reparto, esperienza, stato, creato_il)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $dati['nome'],
            $dati['email'],
            $dati['reparto'],
            $dati['esperienza'],
            $dati['stato'],
            $dati['creato_il'],
            $dati['id']
        ]);

        echo json_encode(['id' => $pdo->lastInsertId(), 'successo' => true]);
        break;

    case 'PUT':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            UPDATE candidature
            SET nome = ?, email = ?, reparto = ?, esperienza = ?, stato = ?, creato_il = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $dati['nome'],
            $dati['email'],
            $dati['reparto'],
            $dati['esperienza'],
            $dati['stato'],
            $dati['creato_il']
        ]);

        echo json_encode(['successo' => true]);
        break;

    case 'DELETE':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("DELETE FROM candidature WHERE id = ?");
        $stmt->execute([$dati['id']]);

        echo json_encode(['successo' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['errore' => 'Metodo non consentito']);
}

?>