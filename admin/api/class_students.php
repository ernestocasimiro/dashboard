<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $turma_id = (int)($data['turma_id'] ?? 0);
    $alunos = $data['alunos'] ?? [];

    if ($turma_id === 0 || !is_array($alunos)) {
        $response['message'] = 'Dados inválidos.';
    } else {
        try {
            $query = "UPDATE students SET turma_id = :turma_id WHERE id = :aluno_id";
            $stmt = $conn->prepare($query);

            foreach ($alunos as $aluno_id) {
                $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
                $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
                $stmt->execute();
            }

            $response['success'] = true;
            $response['message'] = 'Alunos atribuídos à turma com sucesso.';
        } catch (Exception $e) {
            $response['message'] = 'Erro: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método não permitido';
}

echo json_encode($response);
