<?php
header('Content-Type: application/json');
require_once('../dbconnection.php');

$response = ['success' => false, 'data' => []];

try {
    $query = "SELECT id, nome, parentesco, telefone FROM encarregados ORDER BY nome";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $encarregados = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $encarregados[] = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'parentesco' => $row['parentesco'],
                'telefone' => $row['telefone']
            ];
        }
        $response['success'] = true;
        $response['data'] = $encarregados;
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
?>