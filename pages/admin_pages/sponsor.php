<?php
session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../loginPage.php");
    exit;
}

$ruolo = $_SESSION['ruolo']

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsor — Admin Passione Motorsport</title>

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
            <a href="../TeamPage.php">Pagina Team</a>
            <a href="../../index.php">Pagina Principale</a>

            <p class="admin-nav-group">contenuti</p>
            <a href="news.php">news</a>
            <a href="calendario.php">calendario gare</a>
            <a href="sponsor.php" class="active">sponsor</a>
            <a href="categorie.php">categorie news</a>
            <a href="piloti.php">piloti</a>
            <a href="setupGare.php">setup gare</a>

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
                <h1 class="admin-title">sponsor</h1>
            </div>
        </div>

        <!-- SPONSOR ATTIVI -->
        <div class="admin-panel">
            <h3 id="form-heading">nuovo sponsor</h3>
            <form id="sponsor-form" method="POST">
                <input type="hidden" id="sponsor-id">

                <div class="admin-form-row">
                    <div class="admin-field">
                        <label for="sponsor-nome">nome azienda</label>
                        <input type="text" id="sponsor-nome" required placeholder="es. OfficinaTech">
                    </div>
                    <div class="admin-field">
                        <label for="sponsor-livello">livello</label>
                        <select id="sponsor-livello" required>
                            <option value="supporter">supporter</option>
                            <option value="official partner">official partner</option>
                            <option value="tech partner">tech partner</option>
                        </select>
                    </div>
                </div>

                <div class="admin-field">
                    <label>logo</label>
                    <label class="admin-upload" id="upload-label">
                        clicca per caricare il logo
                        <input type="file" id="sponsor-logo" accept="image/*">
                        <div class="admin-upload-preview" id="upload-preview" style="display:none;">
                            <img id="upload-preview-img" src="" alt="anteprima logo">
                        </div>
                    </label>
                </div>

                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn primary">salva sponsor</button>
                    <button type="button" class="btn" id="cancel-edit" style="display:none;">annulla modifica</button>
                </div>
            </form>
        </div>

        <div class="admin-panel">
            <h3>sponsor attivi</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>azienda</th>
                        <th>livello</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="sponsor-table-body"></tbody>
            </table>
            <div class="admin-empty" id="sponsor-empty" style="display:none;">Nessuno sponsor attivo.</div>
        </div>

        <!-- RICHIESTE DI SPONSORIZZAZIONE -->
        <div class="admin-panel">
            <h3>richieste di sponsorizzazione ricevute</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>azienda</th>
                        <th>referente</th>
                        <th>data</th>
                        <th>stato</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="requests-table-body"></tbody>
            </table>
            <div class="admin-empty" id="requests-empty" style="display:none;">Nessuna richiesta ricevuta.</div>
        </div>
    </main>

    <!-- modale dettaglio richiesta -->
    <div class="admin-modal-overlay" id="request-modal">
        <div class="admin-modal">
            <span class="admin-modal-close" onclick="closeRequestModal()">chiudi ✕</span>
            <h3 id="modal-azienda"></h3>
            <p style="color:var(--text-muted); font-size:13px; margin:10px 0;" id="modal-referente"></p>
            <p style="margin-bottom:16px;" id="modal-messaggio"></p>
            <button class="btn primary small" onclick="markRequestReplied()">segna come risposto</button>
        </div>
    </div>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/sponsor.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>