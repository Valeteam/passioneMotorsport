<?php
header('Content-Type: application/json');
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['successo' => false, 'errore' => 'Non autenticato']);
    exit;
}

$dati = json_decode(file_get_contents('php://input'), true);
$percorso = $dati['foto_profilo'] ?? null;

if (!$percorso) {
    http_response_code(400);
    echo json_encode(['successo' => false, 'errore' => 'Percorso mancante']);
    exit;
}

$stmt = $pdo->prepare("UPDATE utenti_admin SET foto_profilo = ? WHERE id = ?");
$stmt->execute([$percorso, $_SESSION['user_id']]);

echo json_encode(['successo' => true]);

?>