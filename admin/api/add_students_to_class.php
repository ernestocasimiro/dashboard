<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $class_id = $data['class_id'] ?? 0;
    $student_ids = $data['student_ids'] ?? [];

    // Verificar se a turma foi especificada e se há alunos para adicionar
    if ($class_id === 0 || empty($student_ids)) {
        $response['message'] = 'Turma ou alunos ausentes.';
    } else {
        try {
            $query = "INSERT INTO class_students (class_id, student_id) VALUES (:class_id, :student_id)";
            $stmt = $conn->prepare($query);
            
            foreach ($student_ids as $student_id) {
                $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
                $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            $response['success'] = true;
            $response['message'] = 'Alunos adicionados à turma com sucesso';
        } catch (Exception $e) {
            $response['message'] = 'Erro: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método não permitido';
}

echo json_encode($response);
?>
