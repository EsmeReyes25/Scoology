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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Calendar</title>
</head>

<body class="overflow-hidden">
    <script type="module" src="js/calendar.js"></script>
    <!-- Incluir la barra de navegación y la barra lateral -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Incluir la barra de navegación -->
                <?php include 'partials/header.php'; ?>
            </div>
        </div>
        <div class="row" style="margin-top: 105px">
            <!-- Incluir la barra lateral -->
            <div class="col-3">
            <?php if (!empty($student)) : ?>
                <?php include 'partials/student-sidebar.html'; ?>
            <?php elseif (!empty($teacher)) : ?>
                <?php include 'partials/teacher-sidebar.html'; ?>
            <?php endif; ?>
            </div>
            <div class="col-8 my-3">
                <!-- Contenido principal -->
                <div class="container">
                    <div class="row d-flex flex-wrap justify-content-center">
                        <i id="prevMonthBtn" class="fa-solid fa-chevron-left" style="width: 5%;"></i>
                        <h1 id="currentMonthYear"></h1>
                        <i id="nextMonthBtn" class="fa-solid fa-chevron-right" style="width: 5%;"></i>
                    </div>
                    <div class="row" id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>