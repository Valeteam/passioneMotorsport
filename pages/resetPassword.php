<?php
session_start();
$step = $_SESSION['reset_step'] ?? 1;
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recupero Password - PassioneMotorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="assets/img/logo/logo.png">

    <link rel="stylesheet" href="../css/resetPassword.css">
</head>

<body>

    <div class="admin_panel">
        <div class="introResPsw">
            <h1>Sicurezza</h1>
            <h1>Reset Password</h1>
        </div>

        <?php if (isset($_GET['errore'])) : ?>
            <p class="error-msg">
                <?php
                if ($_GET['errore'] == 'email_non_trovata') echo "Email non registrata nel sistema.";
                elseif ($_GET['errore'] == 'codice_errato') echo "Codice di verifica non corretto.";
                elseif ($_GET['errore'] == 'password_non_coordinano') echo "Le password non coincidono.";
                elseif ($_GET['errore'] == 'password_corta') echo "La password deve essere di almeno 8 caratteri.";
                else echo "Si è verificato un errore. Riprova.";
                ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_GET['successo'])) : ?>
            <p class="success-msg">
                <?php
                if ($_GET['successo'] == 'codice_inviato') echo "Codice inviato correttamente alla tua email!";
                elseif ($_GET['successo'] == 'password_aggiornata') echo "Password aggiornata con successo! Effettua il login.";
                ?>
            </p>
        <?php endif; ?>


        <?php if ($step == 1): ?>
            <form method="POST" action="../php/resetPsw.php">
                <input type="hidden" name="action" value="send_email">
                <div class="admin-compilation">
                    <label for="email">La tua email</label>
                    <input type="email" id="email" name="email" placeholder="nome@dominio.it" required>
                </div>
                <button type="submit" class="btn pLog">Invia Codice</button>
            </form>


        <?php elseif ($step == 2): ?>
            <form method="POST" action="../php/resetPsw.php">
                <input type="hidden" name="action" value="verify_code">
                <div class="admin-compilation">
                    <label for="code">Codice di verifica</label>
                    <input type="text" id="code" name="code" placeholder="Inserisci il codice ricevuto" required>
                </div>
                <button type="submit" class="btn pLog">Verifica Codice</button>
            </form>

        <?php elseif ($step == 3): ?>
            <form method="POST" action="../php/resetPsw.php">
                <input type="hidden" name="action" value="update_password">
                <div class="admin-compilation">
                    <label for="password1">Nuova password</label>
                    <input type="password" id="password1" name="password" placeholder="Nuova password" required>
                    <input type="checkbox" class="occhio" id="toggle1">
                </div>
                <div class="admin-compilation">
                    <label for="password2">Conferma password</label>
                    <input type="password" id="password2" name="conferma_password" placeholder="Conferma password" required>
                    <input type="checkbox" class="occhio" id="toggle2">
                </div>
                <button type="submit" class="btn pLog">Salva Password</button>
            </form>
        <?php endif; ?>

        <form method="POST" action="../php/resetPsw.php" style="margin-top: 10px;">
            <input type="hidden" name="action" value="restart">
            <button type="submit" style="background:none; border:none; color:var(--yellowBold); cursor:pointer; font-family:var(--mono); font-size:12px; text-transform:uppercase;">Ricomincia da capo</button>
        </form>

        <div class="reset">
            <a href="../loginPage.php">Torna al Login</a>
        </div>
    </div>


    <script>
        const toggle1 = document.getElementById('toggle1');
        const pass1 = document.getElementById('password1');
        if (toggle1 && pass1) {
            toggle1.addEventListener('change', function() {
                pass1.type = this.checked ? 'text' : 'password';
            });
        }

        const toggle2 = document.getElementById('toggle2');
        const pass2 = document.getElementById('password2');
        if (toggle2 && pass2) {
            toggle2.addEventListener('change', function() {
                pass2.type = this.checked ? 'text' : 'password';
            });
        }
    </script>

</body>

</html>