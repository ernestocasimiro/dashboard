<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../dbconnection.php'; // Certifique-se de que este arquivo cria um objeto PDO em $conn

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Erro na conexão com o banco de dados.']);
    exit;
}

try {
    // Seleciona os coordenadores com seus principais dados
    $stmt = $conn->query("SELECT id, fname, lname, username, gender, dob, bi_number, address, contact, email, area FROM coordinators");
    $coordinators = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($coordinators);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Erro ao consultar coordenadores: ' . $e->getMessage()
    ]);
}
?>
