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
        if(count($resultado_student) > 0){
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
    if($resultado){
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
    <title><?php echo $course['name'] ?></title>
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
        <?php include '../partials/student-sidebar.html'; ?>
        <div class="col-8">
        <!-- Contenido principal -->
            <h2><?php echo $course['name'] ?></h2>
            <h5>Teacher: <?php echo $course['teacher'] ?></h5>
            <br>
            <h4>About this course</h4>
            <p><?php echo $course['description'] ?></p>
            <br>
            <h4>Prerequisites</h4>
            <p><?php echo $course['prereq'] ?></p>

            <?php if ($register): ?>
                <p>You are already enrolled in this course</p>
                <a href="../participants.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">View participants</a>
            <?php else: ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Enroll</button>
            <?php endif; ?>
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