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
$percorso = is_array($dati) ? ($dati['foto_profilo'] ?? null) : null;

if (!is_string($percorso) || !preg_match('#^assets/img/piloti/[A-Za-z0-9._-]+\.(jpe?g|png|webp|gif)$#i', $percorso)) {
    http_response_code(400);
    echo json_encode(['successo' => false, 'errore' => 'Percorso non valido']);
    exit;
}

$stmt = $pdo->prepare("UPDATE utenti_admin SET foto_profilo = ? WHERE id = ?");
$stmt->execute([$percorso, (int) $_SESSION['user_id']]);

echo json_encode(['successo' => true]);
