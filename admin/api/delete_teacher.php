<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    die(json_encode(['error' => 'Método não permitido']));
}

try {
    $teacherId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$teacherId) {
        throw new Exception("ID inválido");
    }

    $pdo->beginTransaction();

    // Primeiro excluir as relações com disciplinas
    $stmt = $pdo->prepare("DELETE FROM teacher_subjects WHERE teacher_id = ?");
    $stmt->execute([$teacherId]);

    // Depois excluir o professor
    $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->execute([$teacherId]);

    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}