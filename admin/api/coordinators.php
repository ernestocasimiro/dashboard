<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

ini_set('display_errors', 0); // Altere para 1 para debug
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/coordinators_errors.log');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../dbconnection.php';

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

    $action = $_GET['action'] ?? '';
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $_GET['id'] ?? null;

    switch ($action) {
        case 'get':
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                throw new Exception("Método não permitido para esta ação", 405);
            }

            $stmt = $conn->query("SELECT * FROM coordinators");
            sendJsonResponse(true, 'Lista de coordenadores', $stmt->fetchAll());
            break;

        case 'create':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Método não permitido para esta ação", 405);
            }

            $required = ['fname', 'lname', 'username', 'password', 'area'];
            foreach ($required as $field) {
                if (empty($input[$field])) {
                    throw new Exception("O campo $field é obrigatório", 400);
                }
            }

            $stmt = $conn->prepare("INSERT INTO coordinators 
                (fname, lname, username, gender, dob, bi_number, address, contact, email, password, area) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $success = $stmt->execute([
                $input['fname'],
                $input['lname'],
                $input['username'],
                $input['gender'] ?? null,
                $input['dob'] ?? null,
                $input['bi_number'] ?? null,
                $input['address'] ?? null,
                $input['contact'] ?? null,
                $input['email'] ?? null,
                password_hash($input['password'], PASSWORD_BCRYPT),
                $input['area']
            ]);

            sendJsonResponse(true, 'Coordenador criado com sucesso', ['id' => $conn->lastInsertId()], 201);
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Método não permitido para esta ação", 405);
            }

            if (empty($input['id'])) {
                throw new Exception("ID do coordenador não fornecido", 400);
            }

            $required = ['fname', 'lname', 'username', 'password'];
            foreach ($required as $field) {
                if (empty($input[$field])) {
                    throw new Exception("O campo $field é obrigatório", 400);
                }
            }
            
            // Se quiser validar area apenas SE for enviado:
            if (isset($input['area']) && empty(trim($input['area']))) {
                throw new Exception("O campo area não pode estar vazio se fornecido.", 400);
            }
            

            // Validação de idade mínima (18 anos)
            $dob = $input['dob'];
            $birthDate = new DateTime($dob);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            if ($age < 18) {
                throw new Exception("O coordenador precisa ter pelo menos 18 anos.", 400);
            }

            // Validação do formato do BI
            if (!preg_match('/^\d{7}[A-Za-z]{2}\d{3}$/', $input['bi_number'])) {
                throw new Exception("O número do BI não segue o formato correto.", 400);
            }

            $stmt = $conn->prepare("
                UPDATE coordinators SET
                    fname = :fname,
                    lname = :lname,
                    username = :username,
                    gender = :gender,
                    dob = :dob,
                    bi_number = :bi_number,
                    address = :address,
                    contact = :contact,
                    email = :email,
                    area = :area,
                    updated_at = NOW()
                WHERE id = :id
            ");

            $stmt->execute([
                ':id' => $input['id'],
                ':fname' => trim($input['fname']),
                ':lname' => trim($input['lname']),
                ':username' => trim($input['username']),
                ':gender' => $input['gender'] ?? null,
                ':dob' => $input['dob'] ?? null,
                ':bi_number' => $input['bi_number'] ?? null,
                ':address' => $input['address'] ?? null,
                ':contact' => trim($input['contact']),
                ':email' => filter_var($input['email'] ?? null, FILTER_SANITIZE_EMAIL),
                ':area' => $input['area']
            ]);

            sendJsonResponse(true, 'Coordenador atualizado com sucesso', ['id' => $input['id']]);
            break;

        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
                throw new Exception("Método não permitido para esta ação", 405);
            }

            if (empty($id)) {
                throw new Exception("ID do coordenador não fornecido", 400);
            }

            $stmt = $conn->prepare("SELECT id FROM coordinators WHERE id = :id");
            $stmt->execute([':id' => $id]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Coordenador não encontrado", 404);
            }

            $stmt = $conn->prepare("DELETE FROM coordinators WHERE id = :id");
            $stmt->execute([':id' => $id]);

            sendJsonResponse(true, 'Coordenador excluído com sucesso');
            break;

        default:
            throw new Exception("Ação inválida", 400);
    }

} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    sendJsonResponse(false, 'Erro no banco de dados', null, 500);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    sendJsonResponse(false, $e->getMessage(), null, $e->getCode() ?: 500);
}
?>
