<?php
session_start();
require 'config.php';

$id = $_SESSION['user_id']; // non $_POST['id']
$password_new = $_POST['password'];

$password_new_hash = password_hash($password_new, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE utenti_admin SET password = ? WHERE ID = ?");
$stmt->execute([$password_new_hash, $id]);

header('Location: setting.php');
exit;
?>