<?php
require_once('../dbconnection.php');
header('Content-Type: application/json');

$result = mysqli_query($con, "SELECT id, fname, lname FROM coordinators");
$teachers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $teachers[] = [
        'id' => $row['id'],
        'name' => $row['fname'] . ' ' . $row['lname']
    ];
}

echo json_encode($teachers);
?>
