<?php
require_once __DIR__ . '/../php/api_bootstrap.php';

$cartelle_consentite = [
    'news'       => __DIR__ . '/../assets/img/news/',
    'sponsor'    => __DIR__ . '/../assets/img/sponsor/',
    'piloti'     => __DIR__ . '/../assets/img/piloti/',
    'calendario' => __DIR__ . '/../assets/img/calendario/',
];

$estensioni_per_tipo = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
    'image/gif'  => 'gif',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    errore(405, 'Metodo non consentito');
}

$tipo = $_POST['tipo'] ?? '';
if (!is_string($tipo) || !array_key_exists($tipo, $cartelle_consentite)) {
    errore(400, 'Tipo di upload non valido');
}

if ($tipo === 'piloti') {
    richiediTeam();
} else {
    richiediStaff();
}

if (!isset($_FILES['immagine'])) {
    errore(400, 'Nessun file ricevuto');
}

$file = $_FILES['immagine'];

if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
    errore(400, 'File troppo grande');
}
if ($file['error'] !== UPLOAD_ERR_OK) {
    errore(400, 'Caricamento non riuscito');
}

if ($file['size'] > 10 * 1024 * 1024) {
    errore(400, 'File troppo grande (massimo 5MB)');
}

$tipo_reale = mime_content_type($file['tmp_name']);

if (!isset($estensioni_per_tipo[$tipo_reale]) || @getimagesize($file['tmp_name']) === false) {
    errore(400, 'Formato immagine non consentito');
}

$nome_sicuro = uniqid('img_', true) . '.' . $estensioni_per_tipo[$tipo_reale];

$cartella_destinazione = $cartelle_consentite[$tipo];
if (!is_dir($cartella_destinazione) && !mkdir($cartella_destinazione, 0755, true)) {
    errore(500, 'Cartella di destinazione non disponibile');
}

if (!move_uploaded_file($file['tmp_name'], $cartella_destinazione . $nome_sicuro)) {
    errore(500, 'Salvataggio del file fallito');
}

rispondi([
    'successo' => true,
    'percorso' => 'assets/img/' . $tipo . '/' . $nome_sicuro
], 201);
