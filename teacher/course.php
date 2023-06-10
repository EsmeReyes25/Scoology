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
if ($result) {
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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
            <?php include '../partials/teacher-sidebar.html'; ?>
            <div class="col-8">
                <!-- Contenido principal -->
                <div class="container border border-danger w-75 my-5 rounded">
                    <div class="row align-items-stretch">
                        <div class="col bg d-lg-block"></div>
                        <!-- <div class="col"> -->
                        <div class="col bg-light p-5 d-flex flex-column justify-content-center">
                            <h2 class="d-flex justify-content-center"><?php echo $course['name'] ?></h2>
                            <h4>About this course</h4>
                            <p style="text-align: justify;"><?php echo $course['description'] ?></p>
                            <br>
                            <h4>Prerequisites</h4>
                            <?php if (empty($prerequisites)) : ?>
                                <p>No needed prerequisites</p>
                            <?php else : ?>
                                <p><?php echo $course['prereq'] ?></p>
                            <?php endif; ?>
                            <h6>Students enrolled: <?php echo $course['students'] ?></h6>
                            <br><br>
                            <div class="d-flex justify-content-evenly">
                                <button class="btn btn-primary" style="width:35%" data-bs-toggle="modal" data-bs-target="#staticBackdropEdit">Edit</button>
                                <button class="btn btn-danger" style="width:35%" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                    Are you sure you want to delete the course? <br> This action can not be undone
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="../teacher/delete.php?id=<?php echo $course['course_id'] ?>" type="button" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="staticBackdropEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Confirm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                    Do you want to edit the course?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="../teacher/edit.php?id=<?php echo $course['course_id'] ?>" class="btn btn-warning">Edit</a>
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