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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Log in to Scoology</title>
</head>

<body class="body-index">
    <?php if (!empty($message)) : ?>
        <div class="row w-100">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="alert alert-danger d-flex align-items-center w-75" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                        <div>
                            <?= $message; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- <div class="container border border-danger w-75 bg-primary"> -->
    <div class="container w-75 rounded">
        <div class="row align-items-stretch">
            <div class="col bg d-lg-block">
            </div>
            <!-- <div class="col"> -->
            <div class="col bg-light px-5">
                <h2 class="text-center pt-5 mb-5">Login please</h2>
                <form action="login.php" method="post">
                    <div class="mb-2 d-flex align-items-center">
                        <i class="fa-solid fa-user-tie"></i>
                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <i class="fa-solid fa-lock"></i>
                        <input class="form-control" type="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="row d-flex justify-content-center" style="margin-top: 25px">
                        <input type="submit" class="btn btn-outline-dark w-50" value="Login">
                        <!-- <input type="submit" class="btn-form btn-light" value="Login"> -->
                    </div>
                    <div class="my-1 d-flex justify-content-center" style="padding-bottom: 15px;">
                        <span style="margin-top: -5px";>or
                            <a href="signup.php" class="btn">Signup</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<style>
    .bg {
        background-image: url(./assets/images/light-clouds-background.png);
        background-position: center center;
    }

    .body-index {
        height: 100vh;
        width: 100vw;
        background-size: cover;
        background-attachment: fixed;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-image: url(./assets/images/principal.png);
        justify-content: center;
        font-family: 'Poppins', sans-serif;
    }

    i {
        font-size: 1.5rem;
        padding: .625rem 1.625rem;
    }

    a {
        text-decoration: none;
    }
</style>