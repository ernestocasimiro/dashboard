<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . '/../dbconnection.php';
$uploadDir = __DIR__ . '/../uploads/students/';
$filename = uniqid() . '_' . $_FILES['photo']['name'];
move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $filename);


function sendJson($success, $message = '', $data = null, $code = 200) {
    http_response_code($code);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data,
        'timestamp' => time()
    ]);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método não permitido", 405);
    }

    $json = file_get_contents('php://input');
    $input = json_decode($json, true);

    if (!$input) {
        throw new Exception("Dados JSON inválidos", 400);
    }

    if (!isset($input['student']) || !isset($input['guardian'])) {
        throw new Exception("Dados do aluno ou encarregado ausentes", 400);
    }

    $student = $input['student'];
    $guardian = $input['guardian'];

    // Verifica campos obrigatórios
    if (empty($student['name']) || empty($guardian['contact']) || empty($guardian['name'])) {
        throw new Exception("Campos obrigatórios ausentes", 400);
    }

    // 1. VERIFICA SE O ENCARREGADO JÁ EXISTE PELO CONTACTO
    $stmt = $conn->prepare("SELECT id FROM guardians WHERE contact = :contact LIMIT 1");
    $stmt->execute([':contact' => trim($guardian['contact'])]);
    $existingGuardian = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingGuardian) {
        $guardianId = $existingGuardian['id'];
    } else {
        // 2. INSERE O NOVO ENCARREGADO
        $stmt = $conn->prepare("
            INSERT INTO guardians 
                (name, gender, dob, bi_number, address, contact, email, created_at)
            VALUES 
                (:name, :gender, :dob, :bi_number, :address, :contact, :email, NOW())
        ");
        $stmt->execute([
            ':name' => trim($guardian['name']),
            ':gender' => $guardian['gender'] ?? null,
            ':dob' => $guardian['dob'] ?? null,
            ':bi_number' => $guardian['bi_number'] ?? null,
            ':address' => $guardian['address'] ?? null,
            ':contact' => trim($guardian['contact']),
            ':email' => filter_var($guardian['email'] ?? null, FILTER_SANITIZE_EMAIL)
        ]);

        $guardianId = $conn->lastInsertId();
    }

    // 3. CADASTRA O ALUNO ASSOCIADO AO ENCARREGADO
    $stmt = $conn->prepare("
        INSERT INTO students 
            (name, gender, dob, guardian_id, created_at)
        VALUES 
            (:name, :gender, :dob, :guardian_id, NOW())
    ");
    $stmt->execute([
        ':name' => trim($student['name']),
        ':gender' => $student['gender'] ?? null,
        ':dob' => $student['dob'] ?? null,
        ':guardian_id' => $guardianId
    ]);

    $studentId = $conn->lastInsertId();

    sendJson(true, 'Aluno cadastrado com sucesso', ['student_id' => $studentId, 'guardian_id' => $guardianId], 201);

} catch (Exception $e) {
    error_log("Erro: " . $e->getMessage());
    sendJson(false, $e->getMessage(), null, $e->getCode() ?: 500);
}
