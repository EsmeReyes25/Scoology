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

    $course_id = $_GET['id'];

    $query = "SELECT courses.course_name AS 'course_name',
                    CONCAT(teachers.teacher_name, ' ', teachers.teacher_lastname) AS teacher,
                    CONCAT(students.student_name, ' ', students.student_lastname) AS 'student_name',
                    students.student_email AS 'email',
                    students.student_age AS age,
                    register.reg_date AS 'reg_date'
                FROM students
                INNER JOIN register
                    ON register.reg_student_id = students.student_id
                INNER JOIN courses
                    ON courses.course_id = register.reg_course_id
                INNER JOIN teachers
                    ON courses.course_teach_id = teachers.teacher_id
                WHERE courses.course_id = $course_id
                ORDER BY students.student_name";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title><?php echo $result[0]['course_name'] ?></title>
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
    <div class="row">
        <!-- Incluir la barra lateral -->
        <?php if(!empty($student)): ?>
            <?php include 'partials/student-sidebar.html'; ?>
        <?php elseif(!empty($teacher)): ?>
            <?php include 'partials/teacher-sidebar.html'; ?>
        <?php endif; ?>
        <div class="col-8">
        <!-- Contenido principal -->
            <h2><?php echo $result[0]['course_name'] ?></h2>
            <h5>Teacher: <?php echo $result[0]['teacher'] ?></h5>
            <br>
            <h5>Students enrolled in this course</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Registration date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $student): ?>
                        <tr>
                            <td><?php echo $student['student_name'] ?></td>
                            <td><?php echo $student['email'] ?></td>
                            <td><?php echo $student['age'] ?></td>
                            <td><?php echo $student['reg_date'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</body>
</html>