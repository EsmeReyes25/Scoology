<?php 
    session_start();
    require 'connection.php';
    if (isset($_SESSION['student_id'])) {
        $query = "SELECT * FROM students WHERE student_id = :id";
        $registro = $conn->prepare($query);
        $registro->bindParam(':id', $_SESSION['student_id']);
        $registro->execute();
        $resultado = $registro->fetch(PDO::FETCH_ASSOC);
        $student = null;
        if(count($resultado) > 0){
            $student = $resultado;
        }
    } else if (isset($_SESSION['teacher_id'])) {
        $query = "SELECT * FROM teachers WHERE teacher_id = :id";
        $registro = $conn->prepare($query);
        $registro->bindParam(':id', $_SESSION['teacher_id']);
        $registro->execute();
        $resultado = $registro->fetch(PDO::FETCH_ASSOC);
        $teacher = null;
        if(count($resultado) > 0){
            $teacher = $resultado;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title>Welcome to Scoology</title>
</head>
<body class="body-index">
<div class="box">
    <div class="container">
        <?php if(!empty($student)): ?>
            <br>Welcome <?= $student['student_name']; ?>
            <br><br> You are succesfully logged in!<br><br>
            <a href="student/home.php" class="btn btn-index" style="margin-bottom: 6px;">Home</a>
            <a href="logout.php" class="btn btn-index" style="margin-top: 0;">Logout</a>
        <?php elseif(!empty($teacher)): ?>
            <br>Welcome <?= $teacher['teacher_name']; ?>
            <br><br> You are succesfully logged in!<br><br>
            <a href="teacher/home.php" class="btn btn-index" style="margin-bottom: 6px;">Home</a>
            <a href="logout.php" class="btn btn-index" style="margin-top: 0;">Logout</a>
        <?php else: ?>
            <h1>Start learning</h1>
            <a href="student/login.php" class="btn btn-index" style="margin-bottom: 6px;">Login</a>
            <h1>Don't have an account?</h1>
            <a href="student/signup.php" class="btn btn-index" style="margin-top: 0;">Sign up</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>