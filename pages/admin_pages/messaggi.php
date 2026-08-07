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
    <title>Messaggi — Admin Passione Motorsport</title>

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
                <span class="admin-eyebrow">richieste</span>
                <h1 class="admin-title">messaggi contatti</h1>
            </div>
        </div>

        <div class="admin-panel">
            <h3>messaggi ricevuti dal form contatti</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>nome</th>
                        <th>motivo</th>
                        <th>data</th>
                        <th>stato</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="msg-table-body"></tbody>
            </table>
            <div class="admin-empty" id="msg-empty" style="display:none;">Nessun messaggio ricevuto.</div>
        </div>
    </main>

    <div class="admin-modal-overlay" id="msg-modal">
        <div class="admin-modal">
            <span class="admin-modal-close" onclick="closeMsgModal()">chiudi ✕</span>
            <h3 id="modal-nome"></h3>
            <p style="color:var(--text-muted); font-size:13px; margin:10px 0;" id="modal-email"></p>
            <p style="font-family:var(--mono); font-size:11px; text-transform:uppercase; color:var(--accent); margin-bottom:14px;"
                id="modal-motivo"></p>
            <p style="margin-bottom:22px; line-height:1.6;" id="modal-testo"></p>
            <button class="btn primary small" onclick="markReplied()">segna come risposto</button>
        </div>
    </div>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/messaggioForm.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>