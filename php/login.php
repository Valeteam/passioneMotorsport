<?php
session_start();
require_once 'config.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM utenti_admin WHERE username = ?");
$stmt->execute([$username]);
$utente = $stmt->fetch();

if ($utente && password_verify($password, $utente['password'])) {

    session_regenerate_id(true);

    $_SESSION['user_id'] = $utente['id'];
    $_SESSION['username'] = $utente['username'];
    $_SESSION['ruolo'] = $utente['ruolo'];

    $staff = in_array($utente['ruolo'], ['admin', 'manager'], true);
    header('Location: ' . ($staff ? '../pages/admin.php' : '../pages/TeamPage.php'));
    exit;
}


usleep(40000000);
header('Location: ../loginPage.php?errore=1');
exit;
