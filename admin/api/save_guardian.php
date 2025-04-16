<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $nome = mysqli_real_escape_string($con, $data['nome'] ?? '');
    $parentesco = mysqli_real_escape_string($con, $data['parentesco'] ?? '');
    $telefone = mysqli_real_escape_string($con, $data['telefone'] ?? '');
    
    if (empty($nome) || empty($parentesco) || empty($telefone)) {
        $response['message'] = 'Todos os campos são obrigatórios';
    } else {
        try {
            $query = "INSERT INTO encarregados (nome, parentesco, telefone) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $nome, $parentesco, $telefone);
            
            if (mysqli_stmt_execute($stmt)) {
                $response['success'] = true;
                $response['message'] = 'Encarregado cadastrado com sucesso';
                $response['id'] = mysqli_insert_id($con);
            } else {
                $response['message'] = 'Erro ao cadastrar encarregado: ' . mysqli_error($con);
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