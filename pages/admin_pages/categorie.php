<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

$ruolo = $_SESSION['ruolo']

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie news — Admin Passione Motorsport</title>
    <link rel="stylesheet" href="../../css/admin.css">
</head>

<body>

    <aside class="admin-sidebar">
        <p class="admin-logo">PASSIONE MOTORSPORT <span>ADMIN</span></p>
        <p class="admin-role" id="admin-role-label">ruolo: <?php echo $ruolo ?></p>

        <nav class="admin-nav">
            <a href="../admin.php">dashboard</a>

            <p class="admin-nav-group">contenuti</p>
            <a href="news.php">news</a>
            <a href="calendario.php">calendario gare</a>
            <a href="sponsor.php">sponsor</a>
            <a href="categorie.php" class="active">categorie news</a>

            <p class="admin-nav-group">richieste</p>
            <a href="messaggi.php">messaggi contatti</a>
            <a href="candidature.php">candidature Pilota</a>

            <p class="admin-nav-group">Impostazioni</p>
            <a href="../../php/setting.php" class="option">settings</a>
            <a href="../../php/logout.php">logout</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div>
                <span class="admin-eyebrow">contenuti</span>
                <h1 class="admin-title">categorie news</h1>
            </div>
        </div>

        <div class="admin-panel">
            <h3 id="form-heading">nuova categoria</h3>
            <form id="cat-form">
                <input type="hidden" id="cat-id">
                <div class="admin-field">
                    <label for="cat-nome">nome categoria</label>
                    <input type="text" id="cat-nome" required placeholder="es. gare, community, annunci">
                </div>
                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn primary">salva categoria</button>
                    <button type="button" class="btn" id="cancel-edit" style="display:none;">annulla modifica</button>
                </div>
            </form>
        </div>

        <div class="admin-panel">
            <h3>categorie esistenti</h3>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:18px;">
                Queste categorie compaiono nel filtro news del sito e nel menu a tendina quando crei un articolo.
                Rinominarne una qui non aggiorna automaticamente gli articoli già pubblicati con quella categoria —
                dovrai modificarli singolarmente in "news".
            </p>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>nome</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cat-table-body"></tbody>
            </table>
            <div class="admin-empty" id="cat-empty" style="display:none;">Nessuna categoria creata.</div>
        </div>
    </main>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/categorie.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>
