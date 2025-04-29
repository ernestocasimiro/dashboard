<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

// Verifique se o diretor_id existe no banco de dados
$stmt = $conn->prepare("SELECT id FROM diretores WHERE id = ?");
$stmt->execute([$diretor_id]);
if (!$stmt->fetch()) {
    $response['message'] = 'diretor_id inválido: ID não encontrado.';
    echo json_encode($response);
    exit;
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Log para depuração (verifique o erro_log do PHP)
    error_log('Dados recebidos: ' . print_r($data, true));

    // Validação dos campos
    $nome = trim($data['nome'] ?? '');
    $ano = trim($data['ano'] ?? '');
    $turno = trim($data['turno'] ?? '');
    $diretor_id = (int)($data['diretor_id'] ?? 0);
    $capacidade = min(25, (int)($data['capacidade'] ?? 25));
    $descricao = trim($data['descricao'] ?? '');
    $alunos = $data['alunos'] ?? [];

    // Verificação dos campos obrigatórios
    if (empty($nome) || empty($ano) || empty($turno) || $diretor_id <= 0) {
        $response['message'] = 'Campos obrigatórios ausentes ou inválidos. Verifique: nome, ano, turno e diretor_id (deve ser um ID válido).';
        echo json_encode($response);
        exit; // Encerra se faltar dados
    }

    try {
        // Inserção da turma
        $query = "INSERT INTO turmas (nome, ano, capacidade, diretor_id, turno, descricao) 
                  VALUES (:nome, :ano, :capacidade, :diretor_id, :turno, :descricao)";
        $stmt = $conn->prepare($query);
        
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':capacidade', $capacidade, PDO::PARAM_INT);
        $stmt->bindParam(':diretor_id', $diretor_id, PDO::PARAM_INT);
        $stmt->bindParam(':turno', $turno);
        $stmt->bindParam(':descricao', $descricao);

        if ($stmt->execute()) {
            $turma_id = $conn->lastInsertId();
            
            // Associa alunos (se houver)
            if (!empty($alunos)) {
                $queryAluno = "UPDATE students SET turma_id = :turma_id WHERE id = :aluno_id";
                $stmtAluno = $conn->prepare($queryAluno);
                
                foreach ($alunos as $aluno_id) {
                    $stmtAluno->bindValue(':turma_id', $turma_id, PDO::PARAM_INT);
                    $stmtAluno->bindValue(':aluno_id', $aluno_id, PDO::PARAM_INT);
                    $stmtAluno->execute();
                }
            }

            $response = [
                'success' => true,
                'message' => 'Turma criada com sucesso!',
                'id' => $turma_id
            ];
        } else {
            $response['message'] = 'Erro no banco de dados: ' . implode(" - ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        $response['message'] = 'Erro ao salvar turma: ' . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Lógica para listar turmas (mantida igual)
    try {
        $stmt = $conn->query("SELECT * FROM turmas");
        $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response = [
            'success' => true,
            'data' => $turmas
        ];
    } catch (PDOException $e) {
        $response['message'] = 'Erro ao consultar turmas: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Método não permitido. Use POST ou GET.';
}

echo json_encode($response);
?>