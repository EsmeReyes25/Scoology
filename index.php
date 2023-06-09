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
    if (count($resultado) > 0) {
        $student = $resultado;
    }
} else if (isset($_SESSION['teacher_id'])) {
    $query = "SELECT * FROM teachers WHERE teacher_id = :id";
    $registro = $conn->prepare($query);
    $registro->bindParam(':id', $_SESSION['teacher_id']);
    $registro->execute();
    $resultado = $registro->fetch(PDO::FETCH_ASSOC);
    $teacher = null;
    if (count($resultado) > 0) {
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
    <link rel="icon" href="./assets/images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <title>Welcome to Scoology</title>
</head>

<body class="body-index">
    <div class="container w-75 my-5 rounded">
        <div class="row align-items-stretch">
            <div class="col bg d-lg-block">
            </div>
            <!-- <div class="col"> -->
            <div class="col bg-light p-5 d-flex justify-content-center">
                <div class="text-center my-2">
                    <?php if (!empty($student)) : ?>

                        <div class="row" style="width: 20rem; height: 15rem">

                            <h3>Welcome <?= $student['student_name']; ?></h3>
                            <p class="my-4">You are succesfully logged in!</p>
                            <div>
                                <a href="student/home.php" class="btn btn-color mx-2" style="width:35%" role="button">Home</a>
                                <a href="logout.php" class="btn btn-color mx-2" style="width:35%">Logout</a>
                            </div>
                        </div>
                    <?php elseif (!empty($teacher)) : ?>
                        <div class="row" style="width: 20rem; height: 15rem">
                            <h5 class="card-title">Welcome <?= $teacher['teacher_name']; ?></h5>
                            <p class="card-text my-5">You are succesfully logged in!</p>
                            <div>
                                <a href="teacher/home.php" class="btn btn-color mx-2" style="width:35%" role="button">Home</a>
                                <a href="logout.php" class="btn btn-color mx-2" style="width:35%">Logout</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row d-flex justify-content-center">
                            <h1>Start learning</h1>
                            <a href="login.php" role="button" class="btn btn-index w-50" style="margin-bottom: 6px;">
                                <h3>Login</h3>
                            </a>
                        </div>
                        <div class="row d-flex justify-content-center" style="margin-top: 25px">
                            <h5>Don't have an account?</h5>
                            <a href="signup.php" class="btn w-50" style="margin-top: 0; padding: 0; text-decoration: underline;">Sign up</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>