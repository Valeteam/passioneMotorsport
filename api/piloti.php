<?php
header('Content-Type: application/json');
require_once '../php/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        $stmt = $pdo->query("
            SELECT id, username, foto_profilo, categoria, ultima_posizione, ruolo
            FROM utenti_admin
            ORDER BY username ASC
        ");
        $risultati = $stmt->fetchAll();
        echo json_encode($risultati);
        break;

    case 'PUT':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            UPDATE utenti_admin
            SET foto_profilo = ?, categoria = ?, ultima_posizione = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $dati['foto_profilo'] ?? null,
            $dati['categoria'] ?? null,
            $dati['ultima_posizione'] ?? null,
            $dati['id']
        ]);

        echo json_encode(['successo' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['errore' => 'Metodo non consentito']);
}

?>