<?php 
session_start();

if (isset($_POST['uname']) && 
    isset($_POST['pass']) && 
    isset($_POST['role'])) { 


    include "../DB_connection.php";

    $uname =$_POST['uname'];
    $pass = $_POST['pass'];
    $role = $_POST['role'];

    // Validações
    if (empty($uname)) {
        $em = "Nome de utilizador é obrigatório!";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($pass)) {
        $em = "Palavra-passe é obrigatória!";
        header("Location: ../login.php?error=$em");
        exit;
    } else if (empty($role)) {
        $em = "Selecione uma opção!";
        header("Location: ../login.php?error=$em");
        exit;
    }else {
        if ($role == '1'){
            $sql = "SELECT * FROM admin 
                    WHERE username = ?";
            $role = "Admin";
        }else if($role == '2'){
            $sql = "SELECT * FROM teachers
                    WHERE username = ?";
                    $role = "Teacher";
        }else {
            $sql = "SELECT * FROM students
                    WHERE username = ?";
                    $role = "Student";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname]);

        if ($stmt->rowCount() == 1){
            $user = $stmt->fetch();
            $username = $user['username'];
            $password = $user['password'];
            $fname = $user['fname'];
            $id = $user['id'];
            if ($username === $uname){
                if (password_verify($pass, $password)){
                    $_SESSION['id'] = $id;
                    $_SESSION['fname'] = $fname;
                    $_SESSION['role'] = $role;
                    header("Location: /dashboardpitruca_copia/admin/index.php");
                    exit;
                }else {
                $em = "Nome de Utilizador ou Palavra-Passe Incorretos!";
                header("Location: ../login.php?error=$em");
                exit;
        }

                    
            }else {
                $em = "Nome de Utilizador ou Palavra-Passe Incorretos!";
                header("Location: ../login.php?error=$em");
                exit;
        }

        }else {
            $em = "Nome de Utilizador ou Palavra-Passe Incorretos!";
            header("Location: ../login.php?error=$em");
            exit;
    }
    }

} else {
    header("Location: ../login.php");
}

?>
