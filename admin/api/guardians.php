<?php
// Início do arquivo - sem espaços ou quebras de linha antes da tag PHP
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Configuração de erros
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/guardians_errors.log');

// Responde a requisições OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Conexão com o banco de dados
require_once __DIR__ . '/../dbconnection.php';

// Função para enviar resposta JSON consistente
function sendJsonResponse($success, $message = '', $data = null, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => time()
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

try {
    if (!isset($conn)) {
        throw new Exception("Erro de conexão com o banco de dados", 500);
    }

    $action = $_GET['action'] ?? null;
    $id = $_GET['id'] ?? null;

    // ==== AÇÃO: LISTAR ENCARREGADOS ====
    if ($action === 'get' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        // Busca específica por ID
        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM guardians WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $guardian = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$guardian) {
                sendJsonResponse(false, 'Encarregado não encontrado', null, 404);
            }

            sendJsonResponse(true, 'Encarregado encontrado', $guardian);
        }

        // Lista todos os encarregados
        $stmt = $conn->prepare("
            SELECT 
                id, name, gender, contact, email, 
                DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') as created_at
            FROM guardians
            ORDER BY created_at DESC
        ");
        $stmt->execute();
        $guardians = $stmt->fetchAll(PDO::FETCH_ASSOC);

        sendJsonResponse(true, 'Lista de encarregados', $guardians);
    }

    // ==== AÇÃO: CRIAR/ATUALIZAR ENCARREGADO ====
    if (($action === 'create' || $action === 'update') && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $json = file_get_contents('php://input');
        $input = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Dados JSON inválidos", 400);
        }

        // Validação dos campos
        $requiredFields = ['name', 'contact'];
        foreach ($requiredFields as $field) {
            if (empty($input[$field])) {
                throw new Exception("O campo $field é obrigatório", 400);
            }
        }

        // Operação de atualização
        if ($action === 'update') {
            if (empty($input['id'])) {
                throw new Exception("ID do encarregado não fornecido", 400);
            }

            $stmt = $conn->prepare("
                UPDATE guardians SET
                    name = :name,
                    gender = :gender,
                    dob = :dob,
                    bi_number = :bi_number,
                    address = :address,
                    contact = :contact,
                    email = :email,
                    updated_at = NOW()
                WHERE id = :id
            ");

            $params = [
                ':id' => $input['id'],
                ':name' => trim($input['name']),
                ':gender' => $input['gender'] ?? null,
                ':dob' => $input['dob'] ?? null,
                ':bi_number' => $input['bi_number'] ?? null,
                ':address' => $input['address'] ?? null,
                ':contact' => trim($input['contact']),
                ':email' => filter_var($input['email'] ?? null, FILTER_SANITIZE_EMAIL)
            ];

            $stmt->execute($params);
            sendJsonResponse(true, 'Encarregado atualizado com sucesso', ['id' => $input['id']]);
        }

        // Operação de criação
        $stmt = $conn->prepare("
            INSERT INTO guardians (
                name, gender, dob, bi_number, 
                address, contact, email, created_at
            ) VALUES (
                :name, :gender, :dob, :bi_number,
                :address, :contact, :email, NOW()
            )
        ");

        $params = [
            ':name' => trim($input['name']),
            ':gender' => $input['gender'] ?? null,
            ':dob' => $input['dob'] ?? null,
            ':bi_number' => $input['bi_number'] ?? null,
            ':address' => $input['address'] ?? null,
            ':contact' => trim($input['contact']),
            ':email' => filter_var($input['email'] ?? null, FILTER_SANITIZE_EMAIL)
        ];

        $stmt->execute($params);
        $lastId = $conn->lastInsertId();
        sendJsonResponse(true, 'Encarregado criado com sucesso', ['id' => $lastId], 201);
    }

    // ==== AÇÃO: EXCLUIR ENCARREGADO ====
    if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
        if (empty($id)) {
            throw new Exception("ID do encarregado não fornecido", 400);
        }

        // Verifica se o encarregado existe
        $stmt = $conn->prepare("SELECT id FROM guardians WHERE id = :id");
        $stmt->execute([':id' => $id]);
        
        if ($stmt->rowCount() === 0) {
            throw new Exception("Encarregado não encontrado", 404);
        }

        // Exclui o encarregado
        $stmt = $conn->prepare("DELETE FROM guardians WHERE id = :id");
        $stmt->execute([':id' => $id]);

        sendJsonResponse(true, 'Encarregado excluído com sucesso');
    }

    // Se nenhuma ação corresponder
    throw new Exception("Ação inválida ou método não permitido", 400);

} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    sendJsonResponse(false, 'Erro no banco de dados', null, 500);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    sendJsonResponse(false, $e->getMessage(), null, $e->getCode() ?: 500);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);  // Método não permitido
    echo json_encode(['success' => false, 'message' => 'Ação inválida ou método não permitido']);
    exit;
}
