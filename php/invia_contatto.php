<?php
require_once 'config.php';

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$motivo = $_POST['motivo'] ?? 'generico';
$messaggio = trim($_POST['messaggio'] ?? '');
$azienda = trim($_POST['azienda'] ?? '');
$reparto = $_POST['reparto'] ?? '';

function contattoErrore(): void
{
    header('Location: ../index.php?contatto=errore');
    exit;
}
if ($nome === '' || $email === '' || $messaggio === '') {
    contattoErrore();
}

if (mb_strlen($nome) > 100 || mb_strlen($email) > 150 || mb_strlen($azienda) > 150 || mb_strlen($messaggio) > 2000) {
    contattoErrore();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    contattoErrore();
}

if (!in_array($motivo, ['generico', 'candidatura', 'sponsor'], true)) {
    $motivo = 'generico';
}

switch ($motivo) {

    case 'candidatura':
        if ($reparto !== 'esports' && $reparto !== 'reale') {
            contattoErrore();
        }

        $stmt = $pdo->prepare("
            INSERT INTO candidature (nome, email, reparto, esperienza, stato)
            VALUES (?, ?, ?, ?, 'da leggere')
        ");
        $stmt->execute([$nome, $email, $reparto, $messaggio]);
        break;

    case 'sponsor':
        if ($azienda === '') {
            contattoErrore();
        }

        $stmt = $pdo->prepare("
            INSERT INTO richieste_sponsor (azienda, referente, email, messaggio, stato)
            VALUES (?, ?, ?, ?, 'da leggere')
        ");
        $stmt->execute([$azienda, $nome, $email, $messaggio]);
        break;

    default:
        $stmt = $pdo->prepare("
            INSERT INTO messaggi (nome, email, motivo, messaggio, stato)
            VALUES (?, ?, ?, ?, 'da leggere')
        ");
        $stmt->execute([$nome, $email, $motivo, $messaggio]);
}

header('Location: ../index.php?contatto=ok');
exit;
