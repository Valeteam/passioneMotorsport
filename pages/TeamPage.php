<?php

session_start();
require_once '../php/config.php';

function fetchAllQuery(PDO $pdo, string $sql, array $params = []): array
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

$ultimeNews = fetchAllQuery($pdo, "
    SELECT news.*, categorie.nome AS categoria
    FROM news
    LEFT JOIN categorie ON news.categoria_id = categorie.id
    ORDER BY data_pubblicazione DESC
    LIMIT 6
");

$user = fetchAllQuery($pdo, "
    SELECT * FROM utenti_admin ORDER BY ruolo ASC
");
?>

<!DOCTYPE html>
<html lang="ita">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passione Motorsport Team</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/logo/logo.png">


    <link rel="stylesheet" href="../css/components/navbar.css">
    <link rel="stylesheet" href="../css/TeamPage.css">
    <link rel="stylesheet" href="../css/components/footer.css">
    <link rel="stylesheet" href="../css/components/responsive.css">

</head>

<body>

    <!-- navBar -->

    <nav>
        <h2>Passione <span>Motorsport</span> Team</h2>
        <button class="nav-toggle" aria-label="Apri menu">
            ☰
        </button>
        <div class="nav-links">
            <a href="#home" id="homes" aria-current="page">home</a>
            <a href="#setup" id="setups">Setup</a>
            <a href="#news" id="newss">news</a>
            <a href="#driver" id="drivers">Lista Driver</a>
            <a href="../php/setting.php" class="option">settings</a>
            <a href="../php/logout.php">logout</a>
        </div>
    </nav>

    <section class="news" id="news">
        <div class="news-container">

            <div class="news-header">
                <h1 class="news-eyebrow">news</h1>
                <h2 class="news-heading">ultime notizie</h2>
            </div>

            <div class="news-category-filter">
                <button class="news-filter-btn active" data-filter="tutte">tutte</button>
                <button class="news-filter-btn" data-filter="gare">gare</button>
                <button class="news-filter-btn" data-filter="community">community</button>
                <button class="news-filter-btn" data-filter="annunci">annunci</button>
            </div>

            <div class="news-article-grid">
                <?php foreach ($ultimeNews as $articolo): ?>
                    <?php if ($articolo['categoria'] == 'e-rally'): ?>
                        <article class="news-article-card"
                            data-id="<?php echo $articolo['id']; ?>"
                            data-category="<?php echo htmlspecialchars($articolo['categoria']); ?>"
                            data-date="<?php echo $articolo['data_pubblicazione']; ?>">
                            <img class="news-card-image" src="<?php echo htmlspecialchars($articolo['immagine']); ?>" alt="" loading="lazy">
                            <div class="news-card-content">
                                <div class="news-item-meta">
                                    <span class="news-item-tag"><?php echo htmlspecialchars($articolo['categoria']); ?></span>
                                    <span class="news-item-date"><?php echo htmlspecialchars($articolo['data_pubblicazione']); ?></span>
                                </div>
                                <h4 class="news-card-title"><?php echo htmlspecialchars($articolo['titolo']); ?></h4>
                                <p class="news-card-text"><?php echo htmlspecialchars($articolo['descrizione']); ?></p>
                                <a href="#" class="news-readmore-link">leggi tutto →</a>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        </div>
    </section>

    <?php
    $categorie = [
        'rally2' => 'Rally2',
        'rally3' => 'Rally3',
        'rally4' => 'Rally4',
        's1600'  => 'S1600',
        's2000'  => 'S2000',
    ];

    // Esempio struttura dati: per ogni categoria, un array di gare
    // Ogni gara ha un nome e un array di 6 voci di setup
    $gare_esempio = [];
    for ($i = 1; $i <= 20; $i++) {
        $gare_esempio[] = [
            'nome' => 'Gara ' . $i,
            'setup' => [
                'Ammortizzatori' => '-',
                'Molle'          => '-',
                'Barre antirollio' => '-',
                'Differenziale'  => '-',
                'Pneumatici'     => '-',
                'Aerodinamica'   => '-',
            ],
        ];
    }
    ?>

    <section class="setup" id="setup">

        <?php foreach ($categorie as $slug => $nomeCategoria): ?>
            <h3 class="category-title"><?php echo htmlspecialchars($nomeCategoria); ?></h3>

            <div class="<?php echo $slug; ?> race-row">
                <?php foreach ($gare_esempio as $index => $gara):
                    $uid = $slug . '-' . $index; // id univoco per checkbox e label
                ?>
                    <div class="race-ticket">
                        <input type="checkbox" id="race-<?php echo $uid; ?>" class="race-toggle">

                        <label for="race-<?php echo $uid; ?>" class="race-label">
                            <a href="http://" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()">
                                <?php echo htmlspecialchars($gara['nome']); ?>
                            </a>
                        </label>

                        <div class="setup-panel">
                            <label for="race-<?php echo $uid; ?>" class="setup-overlay"></label>
                            <div class="setup-content">
                                <label for="race-<?php echo $uid; ?>" class="setup-close">&times;</label>
                                <h3 class="setup-title"><?php echo htmlspecialchars($nomeCategoria . ' — ' . $gara['nome']); ?></h3>
                                <div class="setup-grid">
                                    <?php foreach ($gara['setup'] as $etichetta => $valore): ?>
                                        <div class="setup-item">
                                            <span class="setup-label"><?php echo htmlspecialchars($etichetta); ?></span>
                                            <span class="setup-value"><?php echo htmlspecialchars($valore); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

    </section>

    <section class="driver" id="driver">
        <h2 class="title">I nostri Driver</h2>
        <div class="content-card">
            <?php foreach ($user as $utente): ?>
                <div class="driver-card">
                    <img src="<?php echo $utente['foto_profilo'] ? htmlspecialchars('../' . $utente['foto_profilo']) : '../assets/img/piloti/placeholder.jpg'; ?>" alt="<?php echo htmlspecialchars($utente['username']); ?>" class="profilo">
                    <h2><?php echo htmlspecialchars($utente['username']) ?></h2>
                    <h2><?php echo htmlspecialchars($utente['categoria']) ?></h2>
                    <h3><?php echo htmlspecialchars($utente['ultima_posizione']) ?></h3>
                    </img>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <script src="../js/admin-storage.js"></script>
    <script src="../js/services/news.js"></script>
    <script src="../js/utils/navbarSwitch.js"></script>
    <script src="../js/services/navbar.js"></script>
    <script src="../js/index.js"></script>


</body>

</html>