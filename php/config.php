<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "passione_motorsport";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_FOUND_ROWS => true,
        ]
    );
} catch (PDOException $e) {
    error_log('Connessione al database fallita: ' . $e->getMessage());
    http_response_code(500);

    if (strpos($_SERVER['SCRIPT_NAME'] ?? '', '/api/') !== false) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['errore' => 'Servizio non disponibile']);
    } else {
        echo 'Servizio temporaneamente non disponibile.';
    }
    exit;
}


function fetchAllQuery(PDO $pdo, string $sql, array $params = []): array
{
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}
