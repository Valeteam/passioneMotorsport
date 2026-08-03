<?php
session_start();

$username_new = $_POST['username'];
$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("UPDATE utente_admin SET username = ? WHERE ID = ?");
$stmt->execute([$username_new, $id]);

$password_new = $_POST['password'];

$password_new_hash = password_hash($password_new, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE utente_admin SET password = ? WHERE ID = ?");
$stmt->execute([$password_new_hash, $id]);

header('Location: setting.php');
exit;
?>