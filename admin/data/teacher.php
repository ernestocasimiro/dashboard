<?php 

function getAllTeachers($conn){
    $sql = "SELECT * FROM teachers";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() >= 1){
        $teachers = $stmt->fetch();
        return $teachers;
    }else {
        return 0;
    }
}



?>