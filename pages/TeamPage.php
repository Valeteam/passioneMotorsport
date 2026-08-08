<?php

session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

require_once '../php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginPage.php");
    exit;
}

$ultimeNews = fetchAllQuery($pdo, "
    SELECT news.*, categorie.nome AS categoria
    FROM news
    LEFT JOIN categorie ON news.categoria_id = categorie.id
    ORDER BY data_pubblicazione DESC
    LIMIT 6
");


$categorie = fetchAllQuery($pdo, "SELECT * FROM categorie_setup ORDER BY nome ASC");

$gare = fetchAllQuery($pdo, "
    SELECT gare_setup.*, categorie_setup.slug AS categoria_slug
    FROM gare_setup
    LEFT JOIN categorie_setup ON gare_setup.categoria_id = categorie_setup.id
    ORDER BY gare_setup.creato_il ASC
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
            <?php if ($_SESSION['ruolo'] === 'admin' || $_SESSION['ruolo'] === 'manager' ): ?>
                <a href="admin.php" target="_blank">Admin Page</a>
            <?php endif; ?>
        </div>
    </nav>

    <section class="news" id="news">
        <div class="news-container">

            <div class="news-header">
                <h1 class="news-eyebrow">news</h1>
                <h2 class="news-heading">ultime notizie</h2>
            </div>

            <div class="news-article-grid">
                <?php foreach ($ultimeNews as $articolo): ?>
                    <?php if ($articolo['categoria'] == 'e-rally'): ?>
                        <article class="news-article-card"
                            data-id="<?php echo $articolo['id']; ?>"
                            data-category="<?php echo htmlspecialchars($articolo['categoria']); ?>"
                            data-date="<?php echo $articolo['data_pubblicazione']; ?>">
                            <img class="news-highlight-image" src="<?php echo htmlspecialchars('../' . $articolo['immagine']) ?>" alt="" loading="lazy">
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

    <section class="setup" id="setup">
        <h2 class="title">Setup Vettura</h2>

        <?php foreach ($categorie as $cat): ?>
            <h3 class="category-title"><?php echo htmlspecialchars($cat['nome']); ?></h3>

            <div class="<?php echo htmlspecialchars($cat['slug']); ?> race-row">
                <?php foreach ($gare as $gara):
                    if ($gara['categoria_slug'] !== $cat['slug']) continue;
                ?>
                    <button type="button"
                        class="race-ticket"
                        data-gara-id="<?php echo $gara['id']; ?>"
                        data-gara-nome="<?php echo htmlspecialchars($cat['nome'] . ' — ' . $gara['nome']); ?>">
                        <?php echo htmlspecialchars($gara['nome']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </section>

    <div class="setup-modal-overlay" id="setup-modal">
        <div class="setup-modal">
            <div class="setup-modal-header">
                <h3 id="setup-modal-titolo">Setup</h3>
                <span class="setup-modal-close" id="setup-modal-close">chiudi ✕</span>
            </div>
            <div class="setup-modal-body" id="setup-modal-body"></div>
        </div>
    </div>

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
    <script src="../js/setup-data.js"></script>
    <script src="../js/setup-box.js"></script>
    <script src="../js/index.js"></script>


</body>

</html>