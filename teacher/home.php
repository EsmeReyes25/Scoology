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
        if(count($resultado) > 0){
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
    <title>Home</title>
</head>
<body>
    <div class="box">
        <div class="container">
            <?php if(!empty($teacher)): ?>
                <br>Welcome <?= $teacher['teacher_name']; ?>
                <br><br> Your courses <br><br>
            <?php endif; ?>
        </div>
    </div>

    <?php foreach($result_courses as $course): ?>
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start" alt="">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $course['name'] ?></h5>
                        <p class="card-text"><small class="text-muted">Students enrolled: <?php echo $course['students'] ?></small></p>
                        <a href="../participants.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">View participants</a>
                        <a href="../teacher/course.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">Details</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</body>
</html>