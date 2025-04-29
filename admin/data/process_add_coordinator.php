<?php
include "../dbconnection.php"; // Conectar ao banco de dados

if (
    isset($_POST['coordinator-fname']) && 
    isset($_POST['coordinator-lname']) &&
    isset($_POST['coordinator-username']) &&
    isset($_POST['coordinator-gender']) &&
    isset($_POST['coordinator-dob']) &&
    isset($_POST['bi-number']) &&
    isset($_POST['coordinator-address']) &&
    isset($_POST['coordinator-area']) &&
    isset($_POST['coordinator-contact']) &&
    isset($_POST['coordinator-email']) &&
    isset($_POST['password'])
) {
    $fname = trim($_POST['coordinator-fname']);
    $lname = trim($_POST['coordinator-lname']);
    $username = trim($_POST['coordinator-username']);
    $gender = $_POST['coordinator-gender'];
    $dob = $_POST['coordinator-dob'];
    $bi_number = $_POST['bi-number'];
    $address = trim($_POST['coordinator-address']);
    $area = trim($_POST['coordinator-area']);
    $contact = trim($_POST['coordinator-contact']);
    $email = trim($_POST['coordinator-email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificação de idade mínima (18 anos)
    $birthdate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($birthdate)->y;
    if ($age < 18) {
        echo json_encode(['success' => false, 'error' => 'O coordenador precisa ter pelo menos 18 anos.']);
        exit;
    }

    // Validação do formato do BI
    if (!preg_match('/^\d{7}[A-Za-z]{2}\d{3}$/', $bi_number)) {
        echo json_encode(['success' => false, 'error' => 'O número do Bilhete de Identidade (BI) não segue o formato correto.']);
        exit;
    }

    // Verificação se o username já existe
    $stmt_check = $pdo->prepare("SELECT id FROM coordinators WHERE username = ?");
    $stmt_check->execute([$username]);
    if ($stmt_check->rowCount() > 0) {
        echo json_encode(['success' => false, 'error' => 'Este nome de usuário já está em uso.']);
        exit;
    }

    // Inserir Coordenador
    $sql = "INSERT INTO coordinators (fname, lname, username, gender, dob, bi_number, address, contact, email, password, area)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        $fname, $lname, $username, $gender, $dob, $bi_number, $address, $contact, $email, $password, $area
    ]);

    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao salvar o coordenador.']);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
}
?>
