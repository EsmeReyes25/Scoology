<?php 
    session_start();
    if (isset($_SESSION['student_id'])) {
        header('Location: ../student/home.php');
    }

    require '../connection.php';
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $registro = $conn->prepare('SELECT student_id, student_email, student_password FROM students WHERE student_email = :email');
        $registro->bindParam(':email', $_POST['email']);
        $registro->execute();
        $student = $registro->fetch(PDO::FETCH_ASSOC);
        $message = '';

        if (count($student) > 0 && password_verify($_POST['password'], $student['student_password'])) {
            $_SESSION['student_id'] = $student['student_id'];
            header('Location: ../student/home.php');
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
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <title>Log in as student</title>
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
                <a href="../student/signup.php" class="btn">Signup</a>
            </span>
            <span> Are you a teacher?
                <a href="../teacher/login.php" class="btn">Start as teacher</a>
            </span>
            <form action="../student/login.php" method="post">
                <input type="email" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
                <input type="submit" class="btn-form" value="Login">
            </form>
        </div>
    </div>
</body>
</html>