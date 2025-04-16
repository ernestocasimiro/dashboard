<?php
// dbconnection.php
$host = 'localhost';
$dbname = 'escolabd';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // ... restante do código
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}