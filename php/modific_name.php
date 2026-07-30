<?php
session_start();
require 'config.php';

$username_new = $_POST['username'];
$id = $_SESSION['user_id'];

$stmt = $pdo->prepare("UPDATE utenti_admin SET username = ? WHERE ID = ?");
$stmt->execute([$username_new, $id]);

$_SESSION['username'] = $username_new; // aggiorna la sessione col nuovo valore

header('Location: setting.php');
exit;
?>