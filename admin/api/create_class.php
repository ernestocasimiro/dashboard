<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// api/create_class.php
include 'db_connection.php'; // Inclua a conexão com o banco de dados

// Recupere os dados do formulário
$classname = $_POST['classname'];
$classyear = $_POST['classyear'];
$classcapacity = $_POST['classcapacity'];
$classdirector = $_POST['classdirector'];
$classschedule = $_POST['classschedule'];
$classdescription = $_POST['classdescription'];

// Verifique se os dados estão corretos
if (empty($classname) || empty($classyear) || empty($classcapacity) || empty($classdirector)) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos obrigatórios precisam ser preenchidos.']);
    exit;
}

// Query para inserir a turma no banco de dados
$query = "INSERT INTO classes (classname, classyear, classcapacity, classdirector, classschedule, classdescription) 
          VALUES ('$classname', '$classyear', '$classcapacity', '$classdirector', '$classschedule', '$classdescription')";

if (mysqli_query($conn, $query)) {
    echo json_encode(['success' => true, 'message' => 'Turma cadastrada com sucesso']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar turma']);
}
?>
