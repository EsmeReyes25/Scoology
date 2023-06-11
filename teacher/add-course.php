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

if (!empty($_POST['name']) && !empty($_POST['description'])) {
    $sql = 'INSERT INTO courses (course_name, course_description, course_prereq, course_teach_id) VALUES (:name, :description, :prereq, :teacher)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':prereq', $_POST['prerequisites']);
    $stmt->bindParam(':teacher', $teacher_id);

    if ($stmt->execute()) {
        header('Location: ../teacher/home.php');
    } else {
        echo 'Something went wrong';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Add course</title>
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
        <div class="row" style="margin-top: 105px">
            <!-- Incluir la barra lateral -->
            <div class="col-3 position-fixed">
                <?php include '../partials/teacher-sidebar.html'; ?>
            </div>
            <div class="col-8 offset-3" style="margin-top:20px">
                <!-- Contenido principal -->
                <div class="container">
                    <div class="row" style="margin-left:150px;">
                        <form action="../teacher/add-course.php" method="post">
                            <div class="my-3">
                                <label for="name" class="form-label">Name of the course</label>
                                <input type="text" name="name" class="form-control w-75" aria-describedby="courseHelp" required>
                                <div id="courseHelp" class="form-text">Enter the name of the course</div>
                            </div>

                            <div class="my-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea type="text" name="description" class="form-control w-75" aria-describedby="descriptionHelp" required></textarea>
                                <div id="descriptionHelp" class="form-text">Enter a brief description of the course</div>
                            </div>

                            <div class="my-3">
                                <label for="prerequisites" class="form-label">Prerequisites (optional)</label>
                                <input type="text" name="prerequisites" class="form-control w-75" aria-describedby="prerequisitesHelp">
                                <div id="prerequisitesHelp" class="form-text">Enter the prerequisites of the course</div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Add course">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>