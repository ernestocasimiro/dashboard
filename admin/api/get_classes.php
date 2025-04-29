<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'data' => []];

try {
    $query = "SELECT 
                t.class_id,
                t.nome,
                t.ano,
                t.capacidade,
                t.diretor_id,
                (SELECT nome FROM diretores WHERE id = t.diretor_id) AS diretor_nome,
                (SELECT COUNT(*) FROM students WHERE turma_id = t.class_id) AS alunos_matriculados
              FROM turmas t
              ORDER BY t.nome";

    $result = mysqli_query($con, $query);

    if ($result) {
        $turmas = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $turmas[] = [
                'id' => $row['class_id'],
                'nome' => $row['nome'],
                'ano' => $row['ano'],
                'capacidade' => $row['capacidade'],
                'diretor_nome' => $row['diretor_nome'] ?? 'Sem diretor',
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
