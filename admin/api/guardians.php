<?php
// Garanta que não há saída antes deste cabeçalho
if (ob_get_level()) ob_end_clean();

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Configuração de erros
ini_set('display_errors', 0); // Mude para 1 temporariamente para debug
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/guardians_errors.log');

// Requisições OPTIONS para CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// ✅ Verifica a ação passada na URL
$action = $_GET['action'] ?? null;
if ($action !== 'create') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Ação inválida'
    ]);
    exit;
}

// Conexão com o banco
require_once __DIR__ . '/../db_connect.php';

try {
    // Verificar método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método não permitido", 405);
    }

    // Obter dados
    $json = file_get_contents('php://input');
    $input = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Dados JSON inválidos", 400);
    }

    // Validação
    $required = ['name', 'contact'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            throw new Exception("O campo $field é obrigatório", 400);
        }
    }

    // Inserção no banco
    $stmt = $conn->prepare("INSERT INTO guardians 
        (name, gender, dob, bi_number, address, contact, email, created_at)
        VALUES (:name, :gender, :dob, :bi_number, :address, :contact, :email, NOW())");

    $success = $stmt->execute([
        ':name' => $input['name'],
        ':gender' => $input['gender'] ?? null,
        ':dob' => $input['dob'] ?? null,
        ':bi_number' => $input['bi_number'] ?? null,
        ':address' => $input['address'] ?? null,
        ':contact' => $input['contact'],
        ':email' => $input['email'] ?? null
    ]);

    if (!$success) {
        throw new Exception("Falha ao salvar no banco de dados", 500);
    }

    // Resposta de sucesso
    echo json_encode([
        'success' => true,
        'message' => 'Encarregado cadastrado com sucesso',
        'id' => $conn->lastInsertId()
    ]);

} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro no banco de dados',
        'error_code' => $e->getCode()
    ]);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    http_response_code($e->getCode() ?: 400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_code' => $e->getCode() ?: 400
    ]);
}
