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
    <title>Piloti — Admin Passione Motorsport</title>

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
            <a href="piloti.php" class="active">piloti</a>
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
                <h1 class="admin-title">piloti</h1>
            </div>
        </div>

        <p style="color:var(--text-dim); font-size:13px; margin-bottom:24px;">
            Gli account dei piloti si creano da phpMyAdmin (tabella <code>utenti_admin</code>, ruolo
            <code>membro</code>). Da qui gestisci solo categoria vettura, ultima posizione e foto profilo
            di chi è già registrato.
        </p>

        <!-- FORM MODIFICA PILOTA -->
        <div class="admin-panel">
            <h3 id="form-heading">seleziona un pilota dalla tabella per modificarlo</h3>
            <form id="pilota-form">
                <input type="hidden" id="pilota-id">

                <div class="admin-field">
                    <label>pilota</label>
                    <p id="pilota-nome-selezionato" style="color:var(--text-muted); font-size:14px;">nessuno selezionato</p>
                </div>

                <div class="admin-form-row">
                    <div class="admin-field">
                        <label for="pilota-categoria">categoria vettura</label>
                        <input type="text" id="pilota-categoria" placeholder="es. R5, Rally2, N4">
                    </div>
                    <div class="admin-field">
                        <label for="pilota-posizione">ultima posizione</label>
                        <input type="text" id="pilota-posizione" placeholder="es. 2° assoluto">
                    </div>
                </div>

                <div class="admin-field">
                    <label>foto profilo</label>
                    <label class="admin-upload" id="upload-label">
                        clicca per caricare la foto
                        <input type="file" id="pilota-foto" accept="image/*">
                        <div class="admin-upload-preview" id="upload-preview" style="display:none;">
                            <img id="upload-preview-img" src="" alt="anteprima foto">
                        </div>
                    </label>
                </div>

                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn primary" id="save-btn" disabled>salva modifiche</button>
                    <button type="button" class="btn" id="cancel-edit" style="display:none;">annulla</button>
                </div>
            </form>
        </div>

        <div class="admin-panel">
            <h3>elenco piloti</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>foto</th>
                        <th>nome</th>
                        <th>categoria vettura</th>
                        <th>ultima posizione</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="piloti-table-body"></tbody>
            </table>
            <div class="admin-empty" id="piloti-empty" style="display:none;">Nessun pilota registrato.</div>
        </div>
    </main>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/piloti.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>