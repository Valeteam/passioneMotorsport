<?php
require_once 'config.php';

// il form pubblico manda i dati come form tradizionale (non JSON),
// quindi qui li leggiamo da $_POST, non da json_decode(php://input)
// come facevamo nelle API dell'admin
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$motivo = $_POST['motivo'] ?? 'generico';
$messaggio = trim($_POST['messaggio'] ?? '');
$azienda = trim($_POST['azienda'] ?? '');
$reparto = $_POST['reparto'] ?? '';

// validazione minima: senza questi tre, non ha senso salvare nulla
if ($nome === '' || $email === '' || $messaggio === '') {
    header("Location: ../index.php?contatto=errore");
    exit;
}

// smistamento in base al motivo scelto: stessa idea che avevi
// avuto tu settimane fa, ora la mettiamo in pratica
switch ($motivo) {

    case 'candidatura':
        // qui serve per forza un reparto valido, coerente con l'ENUM
        // della tabella — se manca o non e' uno dei due valori ammessi,
        // meglio trattarla come messaggio generico piuttosto che
        // rischiare un errore SQL
        if ($reparto !== 'esports' && $reparto !== 'reale') {
            header("Location: ../index.php?contatto=errore");
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO candidature (nome, email, reparto, esperienza, stato)
            VALUES (?, ?, ?, ?, 'da leggere')
        ");
        $stmt->execute([$nome, $email, $reparto, $messaggio]);
        break;

    case 'sponsor':
        // qui il "nome" del form diventa il referente,
        // e serve anche il nome dell'azienda
        if ($azienda === '') {
            header("Location: ../index.php?contatto=errore");
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO richieste_sponsor (azienda, referente, email, messaggio, stato)
            VALUES (?, ?, ?, ?, 'da leggere')
        ");
        $stmt->execute([$azienda, $nome, $email, $messaggio]);
        break;

    default:
        // qualsiasi altro valore (o 'generico') finisce come messaggio normale
        $stmt = $pdo->prepare("
            INSERT INTO messaggi (nome, email, motivo, messaggio, stato)
            VALUES (?, ?, ?, ?, 'da leggere')
        ");
        $stmt->execute([$nome, $email, $motivo, $messaggio]);
}

header("Location: ../index.php?contatto=ok");
exit;
