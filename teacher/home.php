<?php
session_start();
require '../connection.php';
$teacher_id = NULL;
if (isset($_SESSION['teacher_id'])) {
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

$query_courses = "SELECT courses.course_id AS 'course_id',
                            courses.course_name AS 'name',
                            (SELECT COUNT(*) FROM register WHERE register.reg_course_id = courses.course_id) AS students
                        FROM courses
                        INNER JOIN teachers
                            ON teachers.teacher_id = courses.course_teach_id
                        WHERE teachers.teacher_id = $teacher_id
                        ORDER BY courses.course_name";
$stmt = $conn->prepare($query_courses);
$stmt->execute();
$result_courses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Home</title>
</head>

<body>
    <!-- Incluir la barra de navegación y la barra lateral -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Incluir la barra de navegación -->
                <?php include '../partials/header.php'; ?>
            </div>
        </div>
        <div class="row">
            <!-- Incluir la barra lateral -->
            <?php include '../partials/teacher-sidebar.html'; ?>
            <div class="col-8">
                <!-- Contenido principal -->
                <div class="container">
                    <div class="row">
                        <?php if (!empty($teacher)) : ?>
                            <div class="card bg-primary d-flex align-items-center my-3">
                                <div class="card-body">
                                    <h1>Welcome <?= $teacher['teacher_name']; ?></h1>
                                </div>
                            </div>
                            <h2>Your courses</h2>
                        <?php endif; ?>
                    </div>
                    <div class="container d-flex flex-wrap justify-content-between">
                        <?php foreach ($result_courses as $course) : ?>
                            <div class="card mb-3" style="width: 45%;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="..." class="img-fluid rounded-start" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $course['name'] ?></h5>
                                            <p class="card-text"><small class="text-muted">Students enrolled: <?php echo $course['students'] ?></small></p>
                                            <a href="../participants.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary mx-3">View participants</a>
                                            <a href="../teacher/course.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>