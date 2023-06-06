<?php 
    session_start();
    if (isset($_SESSION['teacher_id'])) {
        header('Location: ../teacher/home.php');
    }

    require '../connection.php';
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $registro = $conn->prepare('SELECT teacher_id, teacher_email, teacher_password FROM teachers WHERE teacher_email = :email');
        $registro->bindParam(':email', $_POST['email']);
        $registro->execute();
        $teacher = $registro->fetch(PDO::FETCH_ASSOC);
        $message = '';

        if (count($teacher) > 0 && password_verify($_POST['password'], $teacher['teacher_password'])) {
            $_SESSION['teacher_id'] = $teacher['teacher_id'];
            header('Location: ../teacher/home.php');
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
    <title>Log in as teacher</title>
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
                <a href="../teacher/signup.php" class="btn">Signup</a>
            </span>
            <span> Are you a student?
                <a href="../student/login.php" class="btn">Start as student</a>
            </span>
            <form action="../teacher/login.php" method="post">
                <input type="email" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
                <input type="submit" class="btn-form" value="Login">
            </form>
        </div>
    </div>
</body>
</html>