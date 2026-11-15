<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../loginPage.php');
    exit;
}

$id = (int) $_SESSION['user_id'];
$password_attuale = $_POST['password_attuale'] ?? '';
$password_new = $_POST['password'] ?? '';

if (strlen($password_new) < 8 || strlen($password_new) > 72) {
    header('Location: setting.php?errore=password_non_valida');
    exit;
}

//cambia la password solo conoscendo quella attuale
$stmt = $pdo->prepare("SELECT password FROM utenti_admin WHERE id = ?");
$stmt->execute([$id]);
$utente = $stmt->fetch();

if (!$utente || !password_verify($password_attuale, $utente['password'])) {
    header('Location: setting.php?errore=password_attuale');
    exit;
}

$stmt = $pdo->prepare("UPDATE utenti_admin SET password = ? WHERE id = ?");
$stmt->execute([password_hash($password_new, PASSWORD_DEFAULT), $id]);

session_regenerate_id(true);

header('Location: setting.php?successo=1');
exit;
