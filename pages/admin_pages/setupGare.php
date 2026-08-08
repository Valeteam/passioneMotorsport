<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../loginPage.php");
    exit;
}

$ruolo = $_SESSION['ruolo'];

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup gare — Admin Passione Motorsport</title>

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
            <a href="news.php">news</a>
            <a href="calendario.php">calendario gare</a>
            <a href="sponsor.php">sponsor</a>
            <a href="categorie.php">categorie news</a>
            <a href="piloti.php">piloti</a>
            <a href="setupGare.php" class="active">setup gare</a>

            <p class="admin-nav-group">richieste</p>
            <a href="messaggi.php">messaggi contatti <span class="badge" id="badge-messaggi">0</span></a>
            <a href="candidature.php">candidature roster <span class="badge" id="badge-candidature">0</span></a>

            <p class="admin-nav-group">Impostazioni</p>
            <a href="../../php/setting.php" class="option">settings</a>
            <a href="../../php/logout.php">logout</a>
        </nav>
    </aside>

    <main class="admin-main">
        <div class="admin-topbar">
            <div>
                <span class="admin-eyebrow">contenuti</span>
                <h1 class="admin-title">setup gare</h1>
            </div>
        </div>

        <!-- CREAZIONE NUOVA GARA -->
        <div class="admin-panel">
            <h3>nuova gara</h3>
            <form id="gara-form">
                <div class="admin-form-row">
                    <div class="admin-field">
                        <label for="gara-categoria">categoria</label>
                        <select id="gara-categoria" required></select>
                    </div>
                    <div class="admin-field">
                        <label for="gara-nome">nome gara</label>
                        <input type="text" id="gara-nome" required placeholder="es. Gara 1">
                    </div>
                </div>
                <button type="submit" class="btn primary">crea gara</button>
            </form>
        </div>

        <!-- ELENCO GARE -->
        <div class="admin-panel">
            <h3>gare esistenti</h3>
            <table class="admin-table">
                <thead>
                    <tr><th>categoria</th><th>nome</th><th></th></tr>
                </thead>
                <tbody id="gare-table-body"></tbody>
            </table>
            <div class="admin-empty" id="gare-empty" style="display:none;">Nessuna gara creata.</div>
        </div>

        <!-- COMPILAZIONE VALORI (nascosto finche' non selezioni una gara) -->
        <div class="admin-panel" id="valori-panel" style="display:none;">
            <h3 id="valori-heading">compila setup</h3>
            <form id="valori-form">
                <div id="valori-container"></div>
                <div style="display:flex; gap:12px; margin-top:20px;">
                    <button type="submit" class="btn primary">salva valori</button>
                    <button type="button" class="btn" id="valori-annulla">annulla</button>
                </div>
            </form>
        </div>
    </main>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/setupGare.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>
