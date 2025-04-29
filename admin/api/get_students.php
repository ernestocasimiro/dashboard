<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json'); 
require_once('../dbconnection.php');

$response = ['success' => false, 'message' => ''];

try {
    $query = "SELECT id, fname, lname FROM students"; 
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if ($students) {
        $response['success'] = true;
        $response['data'] = $students;
    } else {
        $response['message'] = 'Nenhum aluno encontrado.';
    }
} catch (Exception $e) {
    $response['message'] = 'Erro ao buscar alunos: ' . $e->getMessage();
}

echo json_encode($response);
