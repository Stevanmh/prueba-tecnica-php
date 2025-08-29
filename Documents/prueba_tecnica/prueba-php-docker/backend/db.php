<?php
// Usamos los mismos datos definidos en docker-compose.yml
$host = 'db'; // ¡Importante! El nombre del servicio de la DB en docker-compose
$dbname = 'products_db';
$user = 'user';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}