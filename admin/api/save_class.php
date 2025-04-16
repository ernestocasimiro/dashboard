<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $nome = mysqli_real_escape_string($con, $data['nome'] ?? '');
    $ano = mysqli_real_escape_string($con, $data['ano'] ?? '');
    $capacidade = min(25, (int)($data['capacidade'] ?? 25));
    
    if (empty($nome) || empty($ano)) {
        $response['message'] = 'Nome e ano da turma são obrigatórios';
    } else {
        try {
            $query = "INSERT INTO turmas (nome, ano, capacidade) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ssi', $nome, $ano, $capacidade);
            
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
                $response['message'] = 'Turma criada com sucesso';
                $response['id'] = mysqli_insert_id($con);
            } else {
                $response['message'] = 'Erro ao criar turma: ' . mysqli_error($con);
            }
        } catch (Exception $e) {
            $response['message'] = 'Erro: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método não permitido';
}

echo json_encode($response);
?>