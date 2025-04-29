<?php
include "../dbconnection.php"; // Conectar ao banco de dados

// Verificar se os dados foram enviados via POST
if (isset($_POST['teacher-name']) && 
    isset($_POST['teacher-gender']) && 
    isset($_POST['teacher-dob']) && 
    isset($_POST['bi-number']) && 
    isset($_FILES['bi-front']) && 
    isset($_FILES['bi-back']) && 
    isset($_POST['teacher-address']) && 
    isset($_POST['teacher-subjects']) && 
    isset($_POST['teacher-contact']) && 
    isset($_POST['teacher-email']) && 
    isset($_POST['password'])) {

    // Obter os dados do formulário
    $teacher_name = $_POST['teacher-name'];
    $teacher_gender = $_POST['teacher-gender'];
    $teacher_dob = $_POST['teacher-dob'];
    $bi_number = $_POST['bi-number'];
    $teacher_address = $_POST['teacher-address'];
    $teacher_contact = $_POST['teacher-contact'];
    $teacher_email = $_POST['teacher-email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $subjects = $_POST['teacher-subjects'];
    $is_coordinator = isset($_POST['is_coordinator']) ? 1 : 0;

    // Verificação de idade mínima (18 anos)
    $dob = new DateTime($teacher_dob);
    $today = new DateTime();
    $age = $today->diff($dob)->y;
    if ($age < 18) {
        echo json_encode(['success' => false, 'error' => 'O professor precisa ter pelo menos 18 anos.']);
        exit;
    }

    // Validação do número do BI (formato: 0000000LA000)
    if (!preg_match('/^\d{7}[A-Za-z]{2}\d{3}$/', $bi_number)) {
        echo json_encode(['success' => false, 'error' => 'O número do Bilhete de Identidade (BI) não segue o formato correto.']);
        exit;
    }

    // Processar o upload dos arquivos de BI
    $bi_front = $_FILES['bi-front']['name'];
    $bi_back = $_FILES['bi-back']['name'];

    $upload_dir = 'uploads/teachers/';
    move_uploaded_file($_FILES['bi-front']['tmp_name'], $upload_dir . $bi_front);
    move_uploaded_file($_FILES['bi-back']['tmp_name'], $upload_dir . $bi_back);

    // Inserir o professor na base de dados
    $sql = "INSERT INTO teacher (name, gender, dob, bi_number, bi_front, bi_back, address, contact, email, password, is_coordinator) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_name, $teacher_gender, $teacher_dob, $bi_number, $bi_front, $bi_back, $teacher_address, $teacher_contact, $teacher_email, $password, $is_coordinator]);

    // Obter o ID do professor inserido
    $teacher_id = $pdo->lastInsertId();

    // Associar as disciplinas ao professor
    foreach ($subjects as $subject_id) {
        $sql_subject = "INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (?, ?)";
        $stmt_subject = $pdo->prepare($sql_subject);
        $stmt_subject->execute([$teacher_id, $subject_id]);
    }

    // Retornar resposta JSON
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
}
?>
