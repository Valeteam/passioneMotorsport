<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../loginPage.php');
    exit;
}

$username_new = trim($_POST['username'] ?? '');
$id = (int) $_SESSION['user_id'];

if (mb_strlen($username_new) < 3 || mb_strlen($username_new) > 50) {
    header('Location: setting.php?errore=nome_non_valido');
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE utenti_admin SET username = ? WHERE id = ?");
    $stmt->execute([$username_new, $id]);
} catch (PDOException $e) {
    if ((int) ($e->errorInfo[1] ?? 0) === 1062) {
        header('Location: setting.php?errore=nome_in_uso');
        exit;
    }
    error_log((string) $e);
    header('Location: setting.php?errore=1');
    exit;
}

$_SESSION['username'] = $username_new;

header('Location: setting.php?successo=1');
exit;
