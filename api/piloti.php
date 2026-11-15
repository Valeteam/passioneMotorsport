<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("
            SELECT id, username, foto_profilo, categoria, ultima_posizione, ruolo
            FROM utenti_admin
            ORDER BY username ASC
        ")->fetchAll());

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("
            UPDATE utenti_admin
            SET foto_profilo = ?, categoria = ?, ultima_posizione = ?
            WHERE id = ?
        ");
        $stmt->execute([
            campoImmagine($dati, 'foto_profilo', 'piloti'),
            campoTesto($dati, 'categoria', 50, false),
            campoTesto($dati, 'ultima_posizione', 50, false),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Pilota non trovato');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
