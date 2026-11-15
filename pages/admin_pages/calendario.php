<?php
require_once __DIR__ . '/../../php/guard_pagina.php';
$ruolo = proteggiPagina(['admin', 'manager'], '../../loginPage.php', '../TeamPage.php');
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario — Admin Passione Motorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="../../assets/img/logo/logo.png">

    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="stylesheet" href="../../css/themes/responsive.css">
</head>

<body>

    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Apri menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="admin-sidebar" id="adminSidebar">
        <p class="admin-logo">PASSIONE MOTORSPORT <span>ADMIN</span></p>
        <p class="admin-role" id="admin-role-label">ruolo: <?php echo htmlspecialchars($ruolo); ?></p>

        <nav class="admin-nav">
            <a href="../admin.php">dashboard</a>
            <a href="../TeamPage.php">Pagina Team</a>
            <a href="../../index.php">Pagina Principale</a>

            <p class="admin-nav-group">contenuti</p>
            <a href="news.php">news</a>
            <a href="calendario.php" class="active">calendario gare</a>
            <a href="sponsor.php">sponsor</a>
            <a href="categorie.php">categorie news</a>
            <a href="piloti.php">piloti</a>
            <a href="setupGare.php">setup gare</a>
            
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
                <h1 class="admin-title">calendario gare</h1>
            </div>
        </div>

        <div class="admin-panel">
            <h3 id="form-heading">nuova gara</h3>
            <form id="race-form">
                <input type="hidden" id="race-id">

                <div class="admin-field">
                    <label for="race-titolo">titolo</label>
                    <input type="text" id="race-titolo" required maxlength="150" placeholder="es. Rally del Titano">
                </div>

                <div class="admin-form-row">
                    <div class="admin-field">
                        <label for="race-data">data</label>
                        <input type="date" id="race-data" required>
                    </div>
                    <div class="admin-field">
                        <label for="race-validita">validità (tipo di campionato)</label>
                        <select id="race-validita" required>
                            <option value="moderno">moderno</option>
                            <option value="storico">storico</option>
                        </select>
                    </div>
                </div>

                <div class="admin-field">
                    <label>immagine</label>
                    <label class="admin-upload" id="upload-label">
                        trascina un'immagine qui o clicca per selezionarla
                        <input type="file" id="race-immagine" accept="image/*">
                        <div class="admin-upload-preview" id="upload-preview" style="display:none;">
                            <img id="upload-preview-img" src="" alt="anteprima">
                        </div>
                    </label>
                </div>

                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn primary">salva gara</button>
                    <button type="button" class="btn" id="cancel-edit" style="display:none;">annulla modifica</button>
                </div>
            </form>
        </div>

        <div class="admin-panel">
            <h3>gare in calendario</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>data</th>
                        <th>titolo</th>
                        <th>validità</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="race-table-body"></tbody>
            </table>
            <div class="admin-empty" id="race-empty" style="display:none;">Nessuna gara in calendario.</div>
        </div>
    </main>

    <script src="../../js/admin-utils.js"></script>
    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/calendario.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>