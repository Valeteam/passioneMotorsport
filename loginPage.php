<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Access PassioneMotorsport</title>

    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/logo/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo/logo.png">
    <link rel="icon" type="image/x-icon" href="assets/img/logo/logo.png">

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/loginPage.css">
</head>

<body>

    <div class="admin_panel">
        <h3>Accesso Admin</h3>
        <?php if (isset($_GET['errore'])) : ?>
            <p>Username o password errati.</p>
        <?php endif ?>

        <form method="POST" action="php/login.php">
            <div class="admin-compilation">
                <label for="username">username</label>
                <input type="text" id="username" name="username" placeholder="inserisci il nome" required>
            </div>
            <div class="admin-compilation">
                <label for="password">password</label>
                <input type="password" id="password" name="password" placeholder="inserisci password" required>
                <input type="checkbox" onclick="showPass()">
            </div>
            <button type="submit" class="btn pLog">entra</button>
        </form>
    </div>

    <script src="js/services/admin/showPassword.js"></script>

</body>

</html>