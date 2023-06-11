<?php
session_start();
require '../connection.php';
$course_id = $_GET['id'];
$student_id = NULL;

if (isset($_SESSION['student_id'])) {
    $query = "SELECT * FROM students WHERE student_id = :id";
    $registro = $conn->prepare($query);
    $registro->bindParam(':id', $_SESSION['student_id']);
    $registro->execute();
    $resultado_student = $registro->fetch(PDO::FETCH_ASSOC);
    $student = null;
    if (count($resultado_student) > 0) {
        $student = $resultado_student;
        $student_id = $student['student_id'];
    }
}

$query = "SELECT courses.course_id AS 'course_id',
                            courses.course_name AS 'name',
                            courses.course_description AS 'description',
                            courses.course_prereq AS prereq,
                            CONCAT(teachers.teacher_name, ' ', teachers.teacher_lastname) AS teacher
                        FROM courses
                        INNER JOIN teachers
                            ON courses.course_teach_id = teachers.teacher_id
                        WHERE courses.course_id = '$course_id'";
$prep = $conn->prepare($query);
$prep->execute();
$resultado = $prep->fetch(PDO::FETCH_ASSOC);
$course = null;
if ($resultado) {
    $course = $resultado;
}

$query_reg = "SELECT * FROM register WHERE register.reg_course_id = '$course_id' AND register.reg_student_id = '$student_id'";
$stmt = $conn->prepare($query_reg);
$stmt->execute();
$register = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <link rel="icon" href="../assets/images/icon.png">
    <title><?php echo $course['name'] ?></title>
</head>
<!-- <body class="body-index"> -->
<!-- Incluir la barra de navegación y la barra lateral -->

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Incluir la barra de navegación -->
                <?php include '../partials/header.php'; ?>
            </div>
        </div>
        <div class="row" style="margin-top: 105px">
            <!-- Incluir la barra lateral -->
            <div class="col-3 position-fixed">
                <?php include '../partials/student-sidebar.html'; ?>
            </div>
            <div class="col-8 offset-3">
                <!-- Contenido principal -->
                <div class="container border border-light w-100 my-5 rounded">
                    <div class="row align-items-stretch">
                        <div class="col course-img d-lg-block"></div>
                        <!-- <div class="col"> -->
                        <div class="col bg-light p-5 d-flex flex-column justify-content-center">
                            <h2 class="d-flex justify-content-center"><?php echo $course['name'] ?></h2>
                            <h5>Teacher: <?php echo $course['teacher'] ?></h5>
                            <br>
                            <h4>About this course</h4>
                            <p style="text-align: justify;"><?php echo $course['description'] ?></p>
                            <br>
                            <h4>Prerequisites</h4>
                            <?php if (empty($prerequisites)) : ?>
                                <p>No needed prerequisites</p>
                            <?php else : ?>
                                <p><?php echo $course['prereq'] ?></p>
                            <?php endif; ?>

                            <?php if ($register) : ?>
                                <p>You are already enrolled in this course</p>
                                <div class="d-flex justify-content-center">
                                    <a href="../participants.php?id=<?php echo $course['course_id'] ?>" class="btn btn-color w-50">View participants</a>
                                </div>
                            <?php else : ?>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-color w-50" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Enroll</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Enroll -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                    Do you want to enroll in this course?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="../student/enroll.php?id=<?php echo $course['course_id'] ?>" class="btn btn-success">Enroll</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>