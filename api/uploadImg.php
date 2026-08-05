<?php
header('Content-Type: application/json');

// cartelle di destinazione consentite: la chiave e' quello che manda il
// frontend nel campo "tipo", il valore e' il percorso reale sul server.
// aggiungere qui una riga per ogni nuova sezione che avra' bisogno di upload.
$cartelle_consentite = [
    'news'    => __DIR__ . '/../assets/img/news/',
    'sponsor' => __DIR__ . '/../assets/img/sponsor/',
    'piloti'  => __DIR__ . '/../assets/img/piloti/',
];

// solo POST ha senso per un upload
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['errore' => 'Metodo non consentito']);
    exit;
}

// 1. il "tipo" deve essere uno di quelli che conosciamo
$tipo = $_POST['tipo'] ?? '';
if (!array_key_exists($tipo, $cartelle_consentite)) {
    http_response_code(400);
    echo json_encode(['errore' => 'Tipo di upload non valido']);
    exit;
}

// 2. deve essere arrivato davvero un file, senza errori di trasferimento
if (!isset($_FILES['immagine']) || $_FILES['immagine']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['errore' => 'Nessun file valido ricevuto']);
    exit;
}

$file = $_FILES['immagine'];

// 3. controllo del tipo REALE del file (non ci fidiamo dell'estensione
//    scritta nel nome, che chiunque puo' cambiare a mano)
$tipi_consentiti = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
$tipo_reale = mime_content_type($file['tmp_name']);

if (!in_array($tipo_reale, $tipi_consentiti)) {
    http_response_code(400);
    echo json_encode(['errore' => 'Formato immagine non consentito']);
    exit;
}

// 4. limite di dimensione: 5 MB
$dimensione_massima = 5 * 1024 * 1024;
if ($file['size'] > $dimensione_massima) {
    http_response_code(400);
    echo json_encode(['errore' => 'File troppo grande (massimo 5MB)']);
    exit;
}

// 5. generiamo un nome file nuovo e sicuro, invece di fidarci di quello
//    originale (che potrebbe contenere spazi, caratteri strani, o essere
//    identico a un file gia' esistente e sovrascriverlo per sbaglio)
$estensione = pathinfo($file['name'], PATHINFO_EXTENSION);
$nome_sicuro = uniqid('img_', true) . '.' . $estensione;

$cartella_destinazione = $cartelle_consentite[$tipo];
$percorso_completo = $cartella_destinazione . $nome_sicuro;

// 6. spostiamo il file dalla posizione temporanea a quella definitiva
if (!move_uploaded_file($file['tmp_name'], $percorso_completo)) {
    http_response_code(500);
    echo json_encode(['errore' => 'Salvataggio del file fallito']);
    exit;
}

// il percorso che restituiamo e quello che va salvato nel database
// (relativo, non l'intero C:\xampp\... — cosi' funziona anche se
// spostate il progetto o lo mettete online su un altro hosting)
$percorso_relativo = 'assets/img/' . $tipo . '/' . $nome_sicuro;

echo json_encode([
    'successo' => true,
    'percorso' => $percorso_relativo
]);
