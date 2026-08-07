<?php
header('Content-Type: application/json');
require_once '../php/config.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        // qui usiamo $_GET perche' e' una richiesta di lettura con un
        // parametro nell'url (?gara=ID) — normale in un'API REST.
        // resta comunque sicuro perche' il valore passa da un prepared
        // statement (?), non viene mai incollato dentro la stringa SQL
        $garaId = $_GET['gara'] ?? null;

        if (!$garaId || !is_numeric($garaId)) {
            http_response_code(400);
            echo json_encode(['errore' => 'Parametro gara mancante o non valido']);
            exit;
        }

        // LEFT JOIN condizionato sulla gara specifica: prendiamo TUTTI i
        // parametri esistenti, con il valore di questa gara se c'e',
        // NULL se per qualche motivo mancasse
        $stmt = $pdo->prepare("
            SELECT setup_parametri.id, setup_parametri.gruppo, setup_parametri.etichetta,
                   setup_parametri.unita, setup_parametri.ordine, setup_valori.valore
            FROM setup_parametri
            LEFT JOIN setup_valori
                ON setup_valori.parametro_id = setup_parametri.id
                AND setup_valori.gara_id = ?
            ORDER BY setup_parametri.gruppo, setup_parametri.ordine
        ");
        $stmt->execute([$garaId]);
        $risultati = $stmt->fetchAll();
        echo json_encode($risultati);
        break;

    case 'PUT':
        // qui aggiorniamo PIU' valori insieme (tutti i parametri di una
        // gara, salvati in un solo click) — il corpo e':
        // { gara_id: 5, valori: [ {parametro_id: 1, valore: 0.20}, ... ] }
        $dati = json_decode(file_get_contents('php://input'), true);

        $garaId = $dati['gara_id'];
        $valori = $dati['valori'];

        $stmt = $pdo->prepare("
            UPDATE setup_valori
            SET valore = ?
            WHERE gara_id = ? AND parametro_id = ?
        ");

        foreach ($valori as $riga) {
            $stmt->execute([
                $riga['valore'] !== '' ? $riga['valore'] : null,
                $garaId,
                $riga['parametro_id']
            ]);
        }

        echo json_encode(['successo' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['errore' => 'Metodo non consentito']);
}

?>
