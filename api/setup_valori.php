<?php
require_once __DIR__ . '/../php/api_bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    richiediTeam();
} else {
    richiediStaff();
}

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        $garaId = filter_var($_GET['gara'] ?? null, FILTER_VALIDATE_INT);

        if ($garaId === false) {
            errore(400, 'Parametro gara mancante o non valido');
        }

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
        rispondi($stmt->fetchAll());

    case 'PUT':
        $dati = leggiBody();
        $garaId = campoIntero($dati, 'gara_id');
        $valori = $dati['valori'] ?? null;

        if (!is_array($valori) || count($valori) === 0 || count($valori) > 200) {
            errore(400, "Campo 'valori' mancante o non valido");
        }

        $righe = [];
        foreach ($valori as $riga) {
            if (!is_array($riga)) {
                errore(400, 'Riga di valori non valida');
            }

            $parametroId = campoIntero($riga, 'parametro_id');
            $valore = $riga['valore'] ?? null;

            if ($valore === null || $valore === '') {
                $valore = null;
            } elseif (!is_numeric($valore) || abs((float) $valore) >= 10000000) {
                errore(400, "Valore non valido per il parametro $parametroId");
            }

            $righe[] = [$valore, $garaId, $parametroId];
        }

        $stmt = $pdo->prepare("
            UPDATE setup_valori
            SET valore = ?
            WHERE gara_id = ? AND parametro_id = ?
        ");

        $pdo->beginTransaction();
        try {
            foreach ($righe as $r) {
                $stmt->execute($r);
            }
            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
