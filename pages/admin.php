<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginPage.php");
    exit;
}

$ruolo = $_SESSION['ruolo']

?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Admin Passione Motorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/logo/logo.png">

    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

    <aside class="admin-sidebar">
        <p class="admin-logo">PASSIONE MOTORSPORT <span>ADMIN</span></p>
        <p class="admin-role" id="admin-role-label">ruolo: <?php echo $ruolo ?></p>

        <nav class="admin-nav">
            <a href="admin.php" class="active">dashboard</a>

            <p class="admin-nav-group">contenuti</p>
            <a href="admin_pages/news.php">news</a>
            <a href="admin_pages/calendario.php">calendario gare</a>
            <a href="admin_pages/sponsor.php">sponsor</a>
            <a href="admin_pages/categorie.php">categorie news</a>
            <a href="admin_pages/piloti.php">piloti</a>

            <p class="admin-nav-group">richieste</p>
            <a href="admin_pages/messaggi.php">messaggi contatti <span class="badge" id="badge-messaggi">0</span></a>
            <a href="admin_pages/candidature.php">candidature Pilota<span class="badge" id="badge-candidature">0</span></a>

            <p class="admin-nav-group">Impostazioni</p>
            <a href="../php/setting.php" class="option">settings</a>
            <a href="../php/logout.php">logout</a>

        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div>
                <span class="admin-eyebrow">panoramica</span>
                <h1 class="admin-title">dashboard</h1>
            </div>
        </div>

        <div class="admin-stats" id="stats-container">
            <div class="admin-stat">
                <div class="num" id="stat-news">–</div>
                <div class="lbl">articoli pubblicati</div>
            </div>
            <div class="admin-stat">
                <div class="num" id="stat-gare">–</div>
                <div class="lbl">gare in calendario</div>
            </div>
            <div class="admin-stat">
                <div class="num" id="stat-messaggi">–</div>
                <div class="lbl">messaggi da leggere</div>
            </div>
            <div class="admin-stat">
                <div class="num" id="stat-candidature">–</div>
                <div class="lbl">candidature da leggere</div>
            </div>
        </div>

        <div class="admin-panel">
            <h3>accessi rapidi</h3>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="admin_pages/news.html" class="btn primary">+ nuovo articolo</a>
                <a href="admin_pages/calendario.html" class="btn">+ nuova gara</a>
                <a href="admin_pages/messaggi.html" class="btn">vedi messaggi</a>
                <a href="admin_pages/candidature.html" class="btn">vedi candidature</a>
            </div>
        </div>
    </main>


    <script src="../js/admin-storage.js"></script>
    <script src="../js/admin.js"></script>

</body>

</html>