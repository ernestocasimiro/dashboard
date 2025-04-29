<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');  // Certifique-se de que o caminho está correto

$response = ['success' => false, 'data' => [], 'error' => null];

// Verificando se a conexão com o banco de dados foi bem-sucedida
if (!$con) {
    echo json_encode(['success' => false, 'message' => 'Falha na conexão com o banco de dados']);
    exit;
} else {
    echo json_encode(['success' => true, 'message' => 'Conexão bem-sucedida']);
    exit;
}

try {
    // Consulta no banco de dados
    $query = "SELECT id, nome, parentesco, telefone FROM encarregados ORDER BY nome";
    $result = mysqli_query($con, $query);

    // Verificando se a consulta falhou
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Erro na consulta SQL: ' . mysqli_error($con)]);
        exit;
    }

    // Coletando os resultados
    $encarregados = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $encarregados[] = [
            'id' => $row['id'],
            'nome' => $row['nome'],
            'parentesco' => $row['parentesco'],
            'telefone' => $row['telefone']
        ];
    }

    // Verificando se há resultados
    if (empty($encarregados)) {
        echo json_encode(['success' => false, 'message' => 'Nenhum encarregado encontrado']);
        exit;
    }

    // Caso a consulta tenha sucesso
    $response['success'] = true;
    $response['data'] = $encarregados;
} catch (Exception $e) {
    // Caso haja algum erro
    $response['error'] = $e->getMessage();
    http_response_code(500);  // Código de erro interno do servidor
}

// Respondendo com o JSON
echo json_encode($response);
?>
