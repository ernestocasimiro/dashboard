<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

require_once 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_coordinator'])) {
    try {
        $fname = filter_input(INPUT_POST, 'coordinator-fname', FILTER_SANITIZE_STRING);
        $lname = filter_input(INPUT_POST, 'coordinator-lname', FILTER_SANITIZE_STRING);
        $username = filter_input(INPUT_POST, 'coordinator-username', FILTER_SANITIZE_STRING);
        $gender = filter_input(INPUT_POST, 'coordinator-gender', FILTER_SANITIZE_STRING);
        $dob = filter_input(INPUT_POST, 'coordinator-dob', FILTER_SANITIZE_STRING);
        $bi_number = filter_input(INPUT_POST, 'bi-number', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'coordinator-address', FILTER_SANITIZE_STRING);
        $area = filter_input(INPUT_POST, 'coordinator-area', FILTER_SANITIZE_STRING);
        $country_code = filter_input(INPUT_POST, 'country-code', FILTER_SANITIZE_STRING);
        $phone_number = filter_input(INPUT_POST, 'coordinator-contact', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'coordinator-email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $subjects = isset($_POST['coordinator-subjects']) ? $_POST['coordinator-subjects'] : [];

        if (empty($fname) || empty($lname) || empty($username) || empty($gender) || empty($dob) || empty($bi_number) || 
            empty($address) || empty($area) || empty($phone_number) || empty($email) || empty($password)) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("O email fornecido é inválido.");
        }

        if (strlen($password) < 8) {
            throw new Exception("A senha deve ter pelo menos 8 caracteres.");
        }

        // Verificação de idade mínima (18 anos)
        $birthdate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($birthdate)->y;
        if ($age < 18) {
            throw new Exception("O coordenador precisa ter pelo menos 18 anos.");
        }

        // Verificar se username já existe
        $stmt_check = $pdo->prepare("SELECT id FROM coordinators WHERE username = ?");
        $stmt_check->execute([$username]);
        if ($stmt_check->rowCount() > 0) {
            throw new Exception("Este nome de usuário já está em uso.");
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO coordinators 
            (fname, lname, username, gender, dob, bi_number, address, contact, email, password, area, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");

        $stmt->execute([
            $fname, $lname, $username, $gender, $dob, $bi_number,
            $address, $country_code . $phone_number, $email, $password_hash, $area
        ]);

        $coordinator_id = $pdo->lastInsertId();

        if (!empty($subjects)) {
            $stmt = $pdo->prepare("INSERT INTO coordinator_subjects (coordinator_id, subject_id, academic_year) 
                                   VALUES (?, ?, ?)");

            $academic_year = date('Y') . '-' . (date('Y') + 1);

            foreach ($subjects as $subject_id) {
                $stmt->execute([$coordinator_id, $subject_id, $academic_year]);
            }
        }

        $pdo->commit();

        $_SESSION['success_message'] = "Coordenador cadastrado com sucesso!";
        header("Location: coordinator.php");
        exit;

    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        $_SESSION['error_message'] = "Erro ao cadastrar coordenador: " . $e->getMessage();
        header("Location: coordinator.php");
        exit;
    }
}
?>
