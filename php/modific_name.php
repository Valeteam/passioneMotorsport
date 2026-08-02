<?php
session_start();
require 'config.php';

$username_new = trim($_POST['username'] ?? '');
$id = $_SESSION['user_id'];

if ($username_new === '') {
    header('Location: setting.php?errore=1');
    exit;
}

$stmt = $pdo->prepare("UPDATE utenti_admin SET username = ? WHERE id = ?");
$stmt->execute([$username_new, $id]);

$_SESSION['username'] = $username_new;

header('Location: setting.php');
exit;

?>