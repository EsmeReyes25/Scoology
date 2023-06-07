<?php 
    require '../connection.php';
    $course_id = $_GET['id'];

    $query = "SELECT courses.course_id AS 'course_id',
                    courses.course_name AS 'name',
                    courses.course_description AS 'description',
                    courses.course_prereq AS prereq,
                    COUNT(students.student_name) AS students
                FROM courses
                INNER JOIN register
                    ON courses.course_id = register.reg_course_id
                INNER JOIN students
                    ON students.student_id = register.reg_student_id
                WHERE courses.course_id = $course_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $course = null;
    if($result){
        $course = $result;
    } 
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
    <h2><?php echo $course['name'] ?></h2>
    <br>
    <h4>About this course</h4>
    <p><?php echo $course['description'] ?></p>
    <br>
    <h4>Prerequisites</h4>
    <p><?php echo $course['prereq'] ?></p>
    <br>
    <h6>Students enrolled: <?php echo $course['students'] ?></h6>
    <br><br>
    <a href="../teacher/edit.php?id=<?php echo $course['course_id'] ?>" class="btn btn-primary">Edit</a>
    <a href="../teacher/delete.php?id=<?php echo $course['course_id'] ?>" class="btn btn-danger">Delete</a>
</body>
</html>