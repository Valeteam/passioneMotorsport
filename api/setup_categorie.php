<?php
require_once __DIR__ . '/../php/api_bootstrap.php';
richiediStaff();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    errore(405, 'Metodo non consentito');
}

rispondi($pdo->query("SELECT * FROM categorie_setup ORDER BY nome ASC")->fetchAll());
