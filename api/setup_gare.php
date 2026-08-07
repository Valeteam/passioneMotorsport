<?php
header('Content-Type: application/json');
require_once '../php/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        // include il nome della categoria (JOIN), utile sia per l'admin
        // che per il sito pubblico
        $stmt = $pdo->query("
            SELECT gare_setup.*, categorie_setup.nome AS categoria_nome, categorie_setup.slug AS categoria_slug
            FROM gare_setup
            LEFT JOIN categorie_setup ON gare_setup.categoria_id = categorie_setup.id
            ORDER BY categorie_setup.nome ASC, gare_setup.creato_il ASC
        ");
        $risultati = $stmt->fetchAll();
        echo json_encode($risultati);
        break;

    case 'POST':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            INSERT INTO gare_setup (categoria_id, nome)
            VALUES (?, ?)
        ");
        $stmt->execute([
            $dati['categoria_id'],
            $dati['nome']
        ]);

        $nuovoId = $pdo->lastInsertId();

        // appena creata la gara, prepariamo subito una riga in setup_valori
        // per OGNI parametro esistente, con valore NULL — cosi' l'admin
        // trova gia' tutti i campi pronti da compilare, invece di doverli
        // creare uno per uno
        $parametri = $pdo->query("SELECT id FROM setup_parametri")->fetchAll();
        $stmtValori = $pdo->prepare("INSERT INTO setup_valori (gara_id, parametro_id, valore) VALUES (?, ?, NULL)");
        foreach ($parametri as $p) {
            $stmtValori->execute([$nuovoId, $p['id']]);
        }

        echo json_encode(['id' => $nuovoId, 'successo' => true]);
        break;

    case 'PUT':
        $dati = json_decode(file_get_contents('php://input'), true);

        $stmt = $pdo->prepare("
            UPDATE gare_setup
            SET categoria_id = ?, nome = ?
            WHERE id = ?
        ");
        $stmt->execute([
            $dati['categoria_id'],
            $dati['nome'],
            $dati['id']
        ]);

        echo json_encode(['successo' => true]);
        break;

    case 'DELETE':
        $dati = json_decode(file_get_contents('php://input'), true);

        // ON DELETE CASCADE sulla foreign key elimina automaticamente
        // anche tutte le righe collegate in setup_valori
        $stmt = $pdo->prepare("DELETE FROM gare_setup WHERE id = ?");
        $stmt->execute([$dati['id']]);

        echo json_encode(['successo' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['errore' => 'Metodo non consentito']);
}

?>
