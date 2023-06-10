<?php 
    session_start();
    require '../connection.php';
    $student_id = NULL;
    if (isset($_SESSION['student_id'])) {
        $query = "SELECT * FROM students WHERE student_id = :id";
        $registro = $conn->prepare($query);
        $registro->bindParam(':id', $_SESSION['student_id']);
        $registro->execute();
        $resultado = $registro->fetch(PDO::FETCH_ASSOC);
        $student = null;
        if(count($resultado) > 0){
            $student = $resultado;
            $student_id = $student['student_id'];
        }
    } 

    $query_courses = "SELECT courses.course_id AS 'course_id',
                            courses.course_name AS 'name',
                            CONCAT(teachers.teacher_name, ' ', teachers.teacher_lastname) AS teacher
                        FROM courses 
                        INNER JOIN register
                            ON register.reg_course_id = courses.course_id
                        INNER JOIN students
                            ON students.student_id = register.reg_student_id
                        INNER JOIN teachers
                            ON teachers.teacher_id = courses.course_teach_id
                        WHERE students.student_id = $student_id
                        ORDER BY register.reg_date";
    $prep = $conn->prepare($query_courses);
    $prep->execute();
    $resultado_courses = $prep->fetchAll();
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
<body class="body-index">
    <!-- Incluir la barra de navegación y la barra lateral -->
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
            <div class="col-8 offset-3 d-flex justify-content-center">
                <!-- Contenido principal -->
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <div class="alert alert-primary my-3 w-75 d-flex justify-content-center" role="alert">
                            <h2>Your courses</h2>
                        </div>
                    </div>
                    <div class="container d-flex flex-wrap justify-content-between">
                        <?php foreach ($resultado_courses as $course) : ?>
                            <div class="card mb-3" style="width: 45%;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="..." class="img-fluid rounded-start" alt="">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $course['name'] ?></h5>
                                            <p class="card-text">Teacher: <?php echo $course['teacher'] ?></p>
                                            <a href="../student/course.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">View</a>
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