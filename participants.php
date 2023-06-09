<?php 
    require 'connection.php';
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title><?php echo $result[0]['course_name'] ?></title>
</head>
<body>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>