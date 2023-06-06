<?php 
    session_start();
    if (isset($_SESSION['student_id'])) {
        header('Location: student/home.php');
        exit();
    } else if (isset($_SESSION['teacher_id'])) {
        header('Location: teacher/home.php');
        exit();
    }

    require 'connection.php';
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $registro_student = $conn->prepare('SELECT student_id, student_email, student_password FROM students WHERE student_email = :email');
        $registro_student->bindParam(':email', $_POST['email']);
        $registro_student->execute();
        $student = $registro_student->fetch(PDO::FETCH_ASSOC);

        $registro_teacher = $conn->prepare('SELECT teacher_id, teacher_email, teacher_password FROM teachers WHERE teacher_email = :email');
        $registro_teacher->bindParam(':email', $_POST['email']);
        $registro_teacher->execute();
        $teacher = $registro_teacher->fetch(PDO::FETCH_ASSOC);

        $message = '';

        if ($student && password_verify($_POST['password'], $student['student_password'])) {
            $_SESSION['student_id'] = $student['student_id'];
            header('Location: student/home.php');
        } else if ($teacher && password_verify($_POST['password'], $teacher['teacher_password'])) {
            $_SESSION['teacher_id'] = $teacher['teacher_id'];
            header('Location: teacher/home.php');
        } else {
            $message = 'Wrong email or password';
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
    <title>Log in to Scoology</title>
</head>
<body>
    <div>
        <?php if(!empty($message)): ?>
            <p>
                <?= $message; ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="box">
        <div class="container" style="width: 60vw;">
            <h1>Login please</h1>
            <span> or
                <a href="signup.php" class="btn">Signup</a>
            </span>
            <form action="login.php" method="post">
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <input type="submit" class="btn-form" value="Login">
            </form>
        </div>
    </div>
</body>
</html>