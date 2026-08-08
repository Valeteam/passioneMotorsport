<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../loginPage.php");
    exit;
}

$nome = $_SESSION['username'];
$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT foto_profilo FROM utenti_admin WHERE id = ?");
$stmt->execute([$userId]);
$utente = $stmt->fetch();
$fotoAttuale = $utente['foto_profilo'] ?? null;

?>

<!DOCTYPE html>
<html lang="ita">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting - Passione Motorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="../assets/img/logo/logo.png">

    <link rel="stylesheet" href="../css/components/setting.css">

</head>

<body>

    <h2 class="intro-text">impostazioni Generali</h2>

    <?php if (isset($_GET['errore'])): ?>
        <p class="setting-errore">Qualcosa non ha funzionato, riprova.</p>
    <?php endif; ?>
    <?php if (isset($_GET['successo'])): ?>
        <p class="setting-successo">Modifica salvata correttamente.</p>
    <?php endif; ?>

    <div class="setting-content">

        <div class="name-setting righe">
            <span>Nome</span><span><?php echo htmlspecialchars($nome); ?></span>
            <form method="POST" action="../php/modific_name.php">
                <div class="change-group">
                    <label for="new_username">password</label>
                    <input type="text" id="new_username" name="username" placeholder="inserisci il nuovo nome" required>
                </div>
                <button type="submit" class="btn pLog">Cambia Password</button>
            </form>
        </div>

        <div class="password-setting righe">
            <span>Password</span>
            <form method="POST" action="../php/modific_password.php">
                <div class="change-group">
                    <label for="new_password">password</label>
                    <input type="password" id="new_password" name="password" placeholder="inserisci la nuova password" required>
                </div>
                <button type="submit" class="btn pLog">Cambia Password</button>
            </form>
        </div>

        <div class="photo-setting righe">
            <span>Foto profilo</span>

            <div class="photo-preview-wrap">
                <img id="foto-preview"
                    src="<?php echo $fotoAttuale ? htmlspecialchars('../' . $fotoAttuale) : '../assets/img/piloti/placeholder.png'; ?>"
                    alt="foto profilo attuale">
            </div>

            <div class="change-group">
                <label for="foto-input" class="btn pLog">scegli una foto</label>
                <input type="file" id="foto-input" accept="image/*" style="display:none;">
            </div>

            <button type="button" id="foto-salva" class="btn pLog" disabled>salva foto</button>
            <p id="foto-stato" class="setting-stato"></p>
        </div>

    </div>

    <script>
        const fotoInput = document.getElementById('foto-input');
        const fotoPreview = document.getElementById('foto-preview');
        const fotoSalva = document.getElementById('foto-salva');
        const fotoStato = document.getElementById('foto-stato');

        let fileScelto = null;

        fotoInput.addEventListener('change', () => {
            fileScelto = fotoInput.files[0];
            if (!fileScelto) return;

            const reader = new FileReader();
            reader.onload = e => {
                fotoPreview.src = e.target.result;
            };
            reader.readAsDataURL(fileScelto);

            fotoSalva.disabled = false;
            fotoStato.textContent = '';
        });

        fotoSalva.addEventListener('click', async () => {
            if (!fileScelto) return;

            fotoSalva.disabled = true;
            fotoStato.textContent = 'caricamento...';

            try {
                const datiUpload = new FormData();
                datiUpload.append('tipo', 'piloti');
                datiUpload.append('immagine', fileScelto);

                const rispostaUpload = await fetch('../api/uploadImg.php', {
                    method: 'POST',
                    body: datiUpload
                });
                const risultatoUpload = await rispostaUpload.json();

                if (!risultatoUpload.successo) {
                    fotoStato.textContent = 'Errore: ' + (risultatoUpload.errore || 'upload fallito');
                    fotoSalva.disabled = false;
                    return;
                }

                const rispostaSalva = await fetch('modific_foto.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        foto_profilo: risultatoUpload.percorso
                    })
                });
                const risultatoSalva = await rispostaSalva.json();

                if (risultatoSalva.successo) {
                    fotoStato.textContent = 'Foto salvata!';
                } else {
                    fotoStato.textContent = 'Errore nel salvataggio.';
                }
            } catch (err) {
                fotoStato.textContent = 'Errore imprevisto, riprova.';
            }

            fotoSalva.disabled = false;
        });
    </script>

</body>

</html>