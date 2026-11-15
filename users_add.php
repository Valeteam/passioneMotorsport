<?php

require_once 'php/config.php';

$username = "Giovanni";
$password = "capo";

$password_hashata = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO utenti_admin (username, password, ruolo) VALUES (? , ? , 'admin')");
$stmt->execute([$username , $password_hashata]);

echo "utente creato correttamente";

?>


// require_once 'php/config.php';

// $username = 'saby';
// $nuovaPassword = 'LaTuaNuovaPassword';

// $stmt = $pdo->prepare("UPDATE utenti_admin SET password = ? WHERE username = ?");
// $stmt->execute([password_hash($nuovaPassword, PASSWORD_DEFAULT), $username]);

// echo "Righe aggiornate: " . $stmt->rowCount();