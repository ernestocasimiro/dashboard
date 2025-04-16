<?php
require_once 'db_connection.php';

header('Content-Type: application/json');

try {
    $teacherId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$teacherId) {
        throw new Exception("ID inválido");
    }

    $stmt = $pdo->prepare("
        SELECT t.*, GROUP_CONCAT(ts.subject_id) AS subject_ids
        FROM teachers t
        LEFT JOIN teacher_subjects ts ON t.id = ts.teacher_id
        WHERE t.id = ?
        GROUP BY t.id
    ");
    
    $stmt->execute([$teacherId]);
    $teacher = $stmt->fetch();

    if (!$teacher) {
        throw new Exception("Professor não encontrado");
    }

    echo json_encode($teacher);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}