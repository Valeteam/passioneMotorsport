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
    <title>Calendario — Admin Passione Motorsport</title>
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
            <a href="calendario.php" class="active">calendario gare</a>
            <a href="sponsor.php">sponsor</a>
            <a href="categorie.php">categorie news</a>

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
                <h1 class="admin-title">calendario gare</h1>
            </div>
        </div>

        <div class="admin-panel">
            <h3 id="form-heading">nuova gara</h3>
            <form id="race-form">
                <input type="hidden" id="race-id">

                <div class="admin-field">
                    <label for="race-nome">nome gara</label>
                    <input type="text" id="race-nome" required placeholder="es. Rally del Titano">
                </div>

                <div class="admin-form-row">
                    <div class="admin-field">
                        <label for="race-reparto">reparto</label>
                        <select id="race-reparto" required>
                            <option value="esports">esports</option>
                            <option value="reale">reale</option>
                        </select>
                    </div>
                    <div class="admin-field">
                        <label for="race-data">data</label>
                        <input type="date" id="race-data" required>
                    </div>
                </div>

                <div class="admin-field">
                    <label for="race-stato">stato</label>
                    <select id="race-stato" required>
                        <option value="in programma">in programma</option>
                        <option value="prossima">prossima</option>
                        <option value="disputata">disputata</option>
                    </select>
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
                        <th>nome gara</th>
                        <th>reparto</th>
                        <th>stato</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="race-table-body"></tbody>
            </table>
            <div class="admin-empty" id="race-empty" style="display:none;">Nessuna gara in calendario.</div>
        </div>
    </main>

    <script src="../../js/admin-storage.js"></script>
    <script src="../../js/admin/calendario.js"></script>
    <script src="../../js/sidebar.js"></script>

</body>

</html>
