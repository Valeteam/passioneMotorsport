<?php
session_start();
require_once 'config.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM utenti_admin WHERE username = ?");
$stmt->execute([$username]);
$utente = $stmt->fetch();

if ($utente && password_verify($password, $utente['password'])) {

    $_SESSION['user_id'] = $utente['id'];
    $_SESSION['username'] = $utente['username'];
    $_SESSION['ruolo'] = $utente['ruolo'];

    header("Location: ../pages/admin.php");
    exit;

} else {
    header("Location: ../loginPage.php?errore=1");
    exit;
}

?>
