<?php 
    session_start();
    require '../connection.php';
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
    } 

    $query_courses = "SELECT courses.course_id AS 'course_id',
                            courses.course_name AS 'name',
                            CONCAT(teachers.teacher_name, ' ', teachers.teacher_lastname) AS teacher,
                            (SELECT COUNT(*) FROM register WHERE register.reg_course_id = courses.course_id) AS students
                        FROM courses
                        INNER JOIN teachers
                            ON courses.course_teach_id = teachers.teacher_id
                        GROUP BY courses.course_id, courses.course_name, CONCAT(teachers.teacher_name, ' ', teachers.teacher_lastname)
                        ORDER BY courses.course_name";
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
    <title>Home</title>
</head>
<body>
    <div class="box">
        <div class="container">
            <?php if(!empty($student)): ?>
                <br>Welcome <?= $student['student_name']; ?>
                <br><br> Available courses <br><br>
            <?php endif; ?>
        </div>
    </div>

    <?php foreach($resultado_courses as $course): ?>
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start" alt="">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $course['name'] ?></h5>
                        <p class="card-text">Teacher: <?php echo $course['teacher'] ?></p>
                        <p class="card-text"><small class="text-muted">Students enrolled: <?php echo $course['students'] ?></small></p>
                        <a href="../student/course.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</body>
</html>