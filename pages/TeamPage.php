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
?>

<!DOCTYPE html>
<html lang="ita">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passione Motorsport Team</title>

    <link rel="icon" type="image/png" sizes="16x16" href="img/logo.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.jpg">
    <link rel="icon" type="image/x-icon" href="img/logo.jpg">


    <link rel="stylesheet" href="../css/components/navbar.css">
    <link rel="stylesheet" href="../css/TeamPage.css">
    <link rel="stylesheet" href="../css/components/footer.css">

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
            <a href="#about" id="abouts">Setup</a>
            <a href="#news" id="newss">news</a>
            <a href="#news" id="newss">Lista Driver</a>
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

    <script src="js/admin-storage.js"></script>
    <script src="js/services/news.js"></script>
    <script src="js/utils/navbarSwitch.js"></script>
    <script src="js/services/navbar.js"></script>
    <script src="js/index.js"></script>


</body>

</html>