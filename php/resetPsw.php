<?php
session_start();
require 'config.php';

$action = $_POST['action'] ?? '';

// Se l'utente vuole ricominciare da capo
if ($action === 'restart') {
    unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_step']);
    header('Location: ../pages/resetPassword.php');
    exit;
}

// STEP 1: Invio codice e verifica email
if ($action === 'send_email') {
    $email = trim($_POST['email'] ?? '');

    $stmt = $pdo->prepare("SELECT id FROM utenti_admin WHERE email = ?");
    $stmt->execute([$email]);
    $utente = $stmt->fetch();

    if (!$utente) {
        header('Location: ../pages/recuperoPassword.php?errore=email_non_trovata');
        exit;
    }

    $codice_random = rand(100000, 999999);

    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_code'] = $codice_random;
    $_SESSION['reset_step'] = 2;


    $to = $email;
    $subject = "Codice verifica per reset password";
    $messaggio = "Buongiorno, grazie per aver contattato il servizio di reset password del team Passione Motorsport  
    \n Di seguito le lascieremo allegato il codice da inserire nel campo di verifica nel nostro sito. \n\n$codice_random
    \n\nLe auguriamo una buona giornata.\nIl team Passione Motorsport";

    if (mail($to, $subject, $messaggio)) {
        echo "Controlla la tua casella di posta";
    }else{
        echo "Errore nell'invio della mail";
    }

    header('Location: ../pages/resetPassword.php?successo=codice_inviato');
    exit;
}

// STEP 2: Verifica la correttezza del codice inserito
if ($action === 'verify_code') {
    $codice_inserito = trim($_POST['code'] ?? '');

    if (!isset($_SESSION['reset_code']) || $codice_inserito != $_SESSION['reset_code']) {
        header('Location: ../pages/resetPassword.php?errore=codice_errato');
        exit;
    }

    $_SESSION['reset_step'] = 3;
    header('Location: ../pages/resetPassword.php');
    exit;
}

// STEP 3: Controllo corrispondenza password in PHP e aggiornamento sul DB
if ($action === 'update_password') {
    if (!isset($_SESSION['reset_email']) || $_SESSION['reset_step'] != 3) {
        header('Location: ../pages/recuperoPassword.php');
        exit;
    }

    $email = $_SESSION['reset_email'];
    $password_new = $_POST['password'] ?? '';
    $conferma_password = $_POST['conferma_password'] ?? '';

    // Controllo corrispondenza password in PHP
    if ($password_new !== $conferma_password) {
        header('Location: ../pages/resetPassword.php?errore=password_non_coordinano');
        exit;
    }

    if (strlen($password_new) < 8 || strlen($password_new) > 72) {
        header('Location: ../pages/resetPassword.php?errore=password_corta');
        exit;
    }

    $stmt = $pdo->prepare("UPDATE utenti_admin SET password = ? WHERE email = ?");
    $stmt->execute([password_hash($password_new, PASSWORD_DEFAULT), $email]);

    unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_step']);

    header('Location: ../pages/resetPassword.php?successo=password_aggiornata');
    exit;
}


header('Location: ../pages/resetPassword.php');
exit;
