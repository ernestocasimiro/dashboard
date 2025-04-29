<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

require_once 'dbconnection.php';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_teacher'])) {
    try {
        // Validar e sanitizar os dados
        $name = filter_input(INPUT_POST, 'teacher-name', FILTER_SANITIZE_STRING);
        $gender = filter_input(INPUT_POST, 'teacher-gender', FILTER_SANITIZE_STRING);
        $dob = filter_input(INPUT_POST, 'teacher-dob', FILTER_SANITIZE_STRING);
        $bi_number = filter_input(INPUT_POST, 'bi-number', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'teacher-address', FILTER_SANITIZE_STRING);
        $country_code = filter_input(INPUT_POST, 'country-code', FILTER_SANITIZE_STRING);
        $phone_number = filter_input(INPUT_POST, 'teacher-contact', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'teacher-email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $subjects = isset($_POST['teacher-subjects']) ? $_POST['teacher-subjects'] : [];
        $is_coordinator = isset($_POST['is_coordinator']) ? 1 : 0;

        // Validações básicas
        if (empty($name) || empty($gender) || empty($dob) || empty($bi_number) || 
            empty($address) || empty($phone_number) || empty($email) || empty($password)) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("O email fornecido é inválido.");
        }

        if (strlen($password) < 8) {
            throw new Exception("A senha deve ter pelo menos 8 caracteres.");
        }

        // Hash da senha
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Processar upload das imagens do BI
        $bi_front_image = null;
        $bi_back_image = null;

        // Diretório para uploads
        $upload_dir = 'uploads/teachers/bi/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Processar frente do BI
        if (isset($_FILES['bi-front']) && $_FILES['bi-front']['error'] === UPLOAD_ERR_OK) {
            $file_ext = pathinfo($_FILES['bi-front']['name'], PATHINFO_EXTENSION);
            $bi_front_image = $upload_dir . 'bi_front_' . uniqid() . '.' . $file_ext;
            move_uploaded_file($_FILES['bi-front']['tmp_name'], $bi_front_image);
        }

        // Processar verso do BI
        if (isset($_FILES['bi-back']) && $_FILES['bi-back']['error'] === UPLOAD_ERR_OK) {
            $file_ext = pathinfo($_FILES['bi-back']['name'], PATHINFO_EXTENSION);
            $bi_back_image = $upload_dir . 'bi_back_' . uniqid() . '.' . $file_ext;
            move_uploaded_file($_FILES['bi-back']['tmp_name'], $bi_back_image);
        }

        // Iniciar transação
        $pdo->beginTransaction();

        // Inserir o professor na tabela teachers
        $stmt = $pdo->prepare("INSERT INTO teachers
            (name, gender, dob, bi_number, address, contact, email, password, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");

        $stmt->execute([
            $name, $gender, $dob, $bi_number, $address,
            $country_code . $phone_number, $email, $password_hash
        ]);

        $teacher_id = $pdo->lastInsertId();

        // Inserir disciplinas do professor
        if (!empty($subjects)) {
            $stmt = $pdo->prepare("INSERT INTO teacher_subjects (teacher_id, subject_id, academic_year) 
                                  VALUES (?, ?, ?)");

            $academic_year = date('Y') . '-' . (date('Y') + 1); // Ex: 2024-2025

            foreach ($subjects as $subject_id) {
                $stmt->execute([$teacher_id, $subject_id, $academic_year]);
            }
        }

        // Confirmar transação
        $pdo->commit();

        // Redirecionar com mensagem de sucesso
        $_SESSION['success_message'] = "Professor cadastrado com sucesso!";
        header("Location: teacher.php");
        exit;

    } catch (Exception $e) {
        // Em caso de erro, desfazer a transação
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // Apagar arquivos enviados em caso de erro
        if (isset($bi_front_image) && file_exists($bi_front_image)) {
            unlink($bi_front_image);
        }
        if (isset($bi_back_image) && file_exists($bi_back_image)) {
            unlink($bi_back_image);
        }

        $_SESSION['error_message'] = "Erro ao cadastrar professor: " . $e->getMessage();
        header("Location: teacher.php");
        exit;
    }
}

// Restante do seu código HTML...
?>
