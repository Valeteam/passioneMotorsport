<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$nome = $_SESSION['username'];
$fotoProfilo = 'cuai'; // da mettere la foto da caricare

?>

<!DOCTYPE html>
<html lang="ita">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting - Passione Motorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="img/logo.jpg">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.jpg">
    <link rel="icon" type="image/x-icon" href="img/logo.jpg">
    <link rel="stylesheet" href="../css/components/setting.css">

</head>

<body>

    <h2 class="intro-text">impostazioni Generali</h2>

    <div class="setting-content">

        <div class="name-setting righe">
            <span>Nome</span><span><?php echo $nome ?></span>
            <form method="POST" action="modific_name.php">
                <div class="change-group">
                    <label for="username">username</label>
                    <input type="text" id="new_username" name="username" placeholder="inserisci il nuovo nome" required>
                </div>
                <button type="submit" class="btn pLog">Cambia Nome</button>
            </form>
        </div>
        

        <div class="password-setting righe">
            <span>Password</span>
            <form method="POST" action="modific_password.php">
                <div class="change-group">
                    <label for="password">password</label>
                    <input type="password" id="new_password" name="password" placeholder="inserisci la nuova password" required>
                </div>
                <button type="submit" class="btn pLog">Cambia Password</button>
            </form>
        </div>

        <div class="photo-setting righe">
            <span>Foto profilo</span>
        </div>

    </div>
</body>

</html>