<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        rispondi($pdo->query("
            SELECT gare_setup.*, categorie_setup.nome AS categoria_nome, categorie_setup.slug AS categoria_slug
            FROM gare_setup
            LEFT JOIN categorie_setup ON gare_setup.categoria_id = categorie_setup.id
            ORDER BY categorie_setup.nome ASC, gare_setup.creato_il ASC
        ")->fetchAll());

    case 'POST':
        $dati = leggiBody();
        $categoriaId = campoIntero($dati, 'categoria_id');
        $nome = campoTesto($dati, 'nome', 100);

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO gare_setup (categoria_id, nome) VALUES (?, ?)");
            $stmt->execute([$categoriaId, $nome]);
            $nuovoId = (int) $pdo->lastInsertId();

            $parametri = $pdo->query("SELECT id FROM setup_parametri")->fetchAll();
            $stmtValori = $pdo->prepare("INSERT INTO setup_valori (gara_id, parametro_id, valore) VALUES (?, ?, NULL)");
            foreach ($parametri as $p) {
                $stmtValori->execute([$nuovoId, $p['id']]);
            }

            $pdo->commit();
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }

        rispondi(['id' => $nuovoId, 'successo' => true], 201);

    case 'PUT':
        $dati = leggiBody();

        $stmt = $pdo->prepare("UPDATE gare_setup SET categoria_id = ?, nome = ? WHERE id = ?");
        $stmt->execute([
            campoIntero($dati, 'categoria_id'),
            campoTesto($dati, 'nome', 100),
            campoIntero($dati, 'id')
        ]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Gara non trovata');
        }
        rispondi(['successo' => true]);

    case 'DELETE':
        $dati = leggiBody();

        $stmt = $pdo->prepare("DELETE FROM gare_setup WHERE id = ?");
        $stmt->execute([campoIntero($dati, 'id')]);

        if ($stmt->rowCount() === 0) {
            errore(404, 'Gara non trovata');
        }
        rispondi(['successo' => true]);

    default:
        errore(405, 'Metodo non consentito');
}
