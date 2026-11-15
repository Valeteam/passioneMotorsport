<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    errore(405, 'Metodo non consentito');
}

function conta(PDO $pdo, string $sql): int
{
    return (int) $pdo->query($sql)->fetchColumn();
}

$statoLetto = "stato = 'da leggere'";

$prossimaGara = $pdo->query("
    SELECT titolo, datazione, validita
    FROM calendario
    WHERE datazione >= CURDATE()
    ORDER BY datazione ASC
    LIMIT 1
")->fetch();

rispondi([
    'totali' => [
        'news'              => conta($pdo, "SELECT COUNT(*) FROM news"),
        'gare'              => conta($pdo, "SELECT COUNT(*) FROM calendario"),
        'sponsor'           => conta($pdo, "SELECT COUNT(*) FROM sponsor"),
        'utenti'            => conta($pdo, "SELECT COUNT(*) FROM utenti_admin"),
        'messaggi'          => conta($pdo, "SELECT COUNT(*) FROM messaggi"),
        'candidature'       => conta($pdo, "SELECT COUNT(*) FROM candidature"),
        'richieste_sponsor' => conta($pdo, "SELECT COUNT(*) FROM richieste_sponsor"),
        'gare_setup'        => conta($pdo, "SELECT COUNT(*) FROM gare_setup"),
    ],
    'da_leggere' => [
        'messaggi'          => conta($pdo, "SELECT COUNT(*) FROM messaggi WHERE $statoLetto"),
        'candidature'       => conta($pdo, "SELECT COUNT(*) FROM candidature WHERE $statoLetto"),
        'richieste_sponsor' => conta($pdo, "SELECT COUNT(*) FROM richieste_sponsor WHERE $statoLetto"),
    ],
    'news_per_categoria' => $pdo->query("
        SELECT COALESCE(categorie.nome, 'senza categoria') AS nome, COUNT(*) AS totale
        FROM news
        LEFT JOIN categorie ON news.categoria_id = categorie.id
        GROUP BY categorie.nome
        ORDER BY totale DESC
    ")->fetchAll(),
    'gare_per_validita' => $pdo->query("
        SELECT validita AS nome, COUNT(*) AS totale
        FROM calendario
        GROUP BY validita
    ")->fetchAll(),
    'candidature_per_reparto' => $pdo->query("
        SELECT reparto AS nome, COUNT(*) AS totale
        FROM candidature
        GROUP BY reparto
    ")->fetchAll(),
    'utenti_per_categoria' => $pdo->query("
        SELECT COALESCE(categoria, 'non assegnata') AS nome, COUNT(*) AS totale
        FROM utenti_admin
        GROUP BY categoria
        ORDER BY totale DESC
    ")->fetchAll(),
    'contatti_per_mese' => $pdo->query("
        SELECT DATE_FORMAT(creato_il, '%Y-%m') AS mese, COUNT(*) AS totale
        FROM (
            SELECT creato_il FROM messaggi
            UNION ALL SELECT creato_il FROM candidature
            UNION ALL SELECT creato_il FROM richieste_sponsor
        ) AS contatti
        WHERE creato_il >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH), '%Y-%m-01')
        GROUP BY mese
        ORDER BY mese ASC
    ")->fetchAll(),
    'prossima_gara' => $prossimaGara ?: null,
]);
