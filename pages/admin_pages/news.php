<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$ruolo = $_SESSION['ruolo'];

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News — Admin Passione Motorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo/logo.png">
    
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>

    <aside class="admin-sidebar">
        <p class="admin-logo">PASSIONE MOTORSPORT <span>ADMIN</span></p>
        <p class="admin-role" id="admin-role-label">ruolo: <?php echo $ruolo ?></p>

        <nav class="admin-nav">
            <a href="../admin.php">dashboard</a>

            <p class="admin-nav-group">contenuti</p>
            <a href="news.php" class="active">news</a>
            <a href="calendario.php">calendario gare</a>
            <a href="sponsor.php">sponsor</a>
            <a href="categorie.php">categorie news</a>

            <p class="admin-nav-group">richieste</p>
            <a href="messaggi.php">messaggi contatti <span class="badge" id="badge-messaggi">0</span></a>
            <a href="candidature.php">candidature Pilota<span class="badge" id="badge-candidature">0</span></a>

            <p class="admin-nav-group">Impostazioni</p>
            <a href="../../php/setting.php" class="option">settings</a>
            <a href="../../php/logout.php">logout</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div>
                <span class="admin-eyebrow">contenuti</span>
                <h1 class="admin-title">news</h1>
            </div>
        </div>

        <!-- FORM NUOVO ARTICOLO -->
        <div class="admin-panel">
            <h3 id="form-heading">nuovo articolo</h3>
            <form id="news-form">
                <input type="hidden" id="news-id">

                <div class="admin-field">
                    <label for="news-title">titolo</label>
                    <input type="text" id="news-title" required placeholder="Titolo dell'articolo">
                </div>

                <div class="admin-field">
                    <label for="news-excerpt">descrizione</label>
                    <textarea id="news-excerpt" required placeholder="Breve sommario dell'articolo"></textarea>
                </div>

                <div class="admin-form-row">
                    <div class="admin-field">
                        <label for="news-category">categoria</label>
                        <select id="news-category" required></select>
                    </div>
                    <div class="admin-field">
                        <label for="news-date">data pubblicazione</label>
                        <input type="date" id="news-date" required>
                    </div>
                </div>

                <div class="admin-field">
                    <label>immagine di copertina</label>
                    <label class="admin-upload" id="upload-label">
                        trascina un'immagine qui o clicca per selezionarla
                        <input type="file" id="news-image" accept="image/*">
                        <div class="admin-upload-preview" id="upload-preview" style="display:none;">
                            <img id="upload-preview-img" src="" alt="anteprima">
                        </div>
                    </label>
                </div>

                <div class="admin-field" style="display:flex; align-items:center; gap:10px;">
                    <input type="checkbox" id="news-featured" style="width:auto;">
                    <label for="news-featured" style="margin:0;">mostra come articolo in evidenza in home</label>
                </div>

                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn primary">pubblica articolo</button>
                    <button type="button" class="btn" id="cancel-edit" style="display:none;">annulla modifica</button>
                </div>
            </form>
        </div>

        <!-- LISTA ARTICOLI ESISTENTI -->
        <div class="admin-panel">
            <h3>articoli pubblicati</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>titolo</th>
                        <th>categoria</th>
                        <th>data</th>
                        <th>evidenza</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="news-table-body"></tbody>
            </table>
            <div class="admin-empty" id="news-empty" style="display:none;">Nessun articolo pubblicato ancora.</div>
        </div>
    </main>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/news.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>