<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'data' => []];

try {
    $query = "SELECT id, nome, capacidade, 
              (SELECT COUNT(*) FROM students WHERE turma_id = turmas.id) as alunos_matriculados 
              FROM turmas 
              ORDER BY nome";
    
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $turmas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $turmas[] = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'capacidade' => $row['capacidade'],
                'alunos_matriculados' => $row['alunos_matriculados']
            ];
        }
        $response['success'] = true;
        $response['data'] = $turmas;
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>