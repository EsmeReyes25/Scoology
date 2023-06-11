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
        $student_id = $student['student_id'];
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
        $teacher_id = $teacher['teacher_id'];
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
    <link rel="icon" href="assets/images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>About</title>
</head>

<body>
    <!-- Incluir la barra de navegación y la barra lateral -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Incluir la barra de navegación -->
                <?php include 'partials/header.php'; ?>
            </div>
        </div>
        <div class="row" style="margin-top: 105px">
            <div class="col-3 position-fixed">
                <!-- Incluir la barra lateral -->
                <?php if (!empty($student)) : ?>
                    <?php include 'partials/student-sidebar.html'; ?>
                <?php elseif (!empty($teacher)) : ?>
                    <?php include 'partials/teacher-sidebar.html'; ?>
                <?php endif; ?>
            </div>
            <div class="col-8 offset-3" style="margin-top:50px">
                <!-- Contenido principal -->
                <div class="container">
                    <h1>About us</h1>
                    <p class="fs-5" style="text-align: justify;">Welcome to Scoology! Our compromise is to provide high-quality educational experiences to help you expand your knowledge and skills. 
                        In this page, you will find detailed information about our courses and what makes them unique.</p>
                    <p class="fs-5" style="text-align: justify;">Our courses are designed by industry experts and experienced instructors who are passionate about sharing their expertise with you. 
                        Whether you're a beginner or an advanced learner, we have courses to suit your needs. From technical subjects like programming and data science 
                        to creative fields like design and photography, our diverse range of courses caters to a wide range of interests.</p>
                    <p class="fs-5" style="text-align: justify;">We believe in the power of collaboration and community. Throughout your learning journey, you'll have access to our vibrant student community, 
                        where you can connect with fellow learners, share insights, and seek guidance. Our instructors are also available to provide support and answer any questions you may have.</p>
                    <p class="fs-5" style="text-align: justify;">Invest in your personal and professional growth by enrolling in our courses. Start your learning journey today and unlock a world of possibilities!</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>