<?php 
    require '../connection.php';
    $course_id = $_GET['id'];

    $query = "SELECT courses.course_id AS 'course_id',
                    courses.course_name AS 'name',
                    courses.course_description AS 'description',
                    courses.course_prereq AS prereq
                FROM courses
                WHERE courses.course_id = $course_id";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $course = null;
    if($result){
        $course = $result;
    }

    if(!empty($_POST['name']) && !empty($_POST['description'])) {
        $sql = "UPDATE courses SET course_name = :name, 
                                    course_description = :description, 
                                    course_prereq = :prereq
                                WHERE course_id = $course_id";
        $prep = $conn->prepare($sql);
        $prep->bindParam(':name', $_POST['name']);
        $prep->bindParam(':description', $_POST['description']);
        $prep->bindParam(':prereq', $_POST['prerequisites']);
        
        if ($prep->execute()) {
            header("Location: ../teacher/course.php?id=$course_id");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Edit course</title>
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
                    <div class="row">
                        <form action="../teacher/edit.php?id=<?php echo $course_id ?>" method="post">
                        <div class="my-3">
                            <label for="name" class="form-label">Name of the course</label>
                            <input type="text" name="name" value="<?php echo $course['name'] ?>" class="form-control w-50" aria-describedby="courseHelp" required>
                            <div id="courseHelp" class="form-text">Enter the name of the course</div>
                        </div>
                        <div class="my-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" value="<?php echo $course['description'] ?>" class="form-control w-50" aria-describedby="courseHelp" required>
                            <div id="courseHelp" class="form-text">Enter a brief description of the course</div>
                        </div>
                        <div class="my-3">
                            <label for="prerequisites" class="form-label">Prerequisites (optional)</label>
                            <input type="text" name="prerequisites" value="<?php echo $course['prereq'] ?>" class="form-control w-50" aria-describedby="courseHelp" required>
                            <div id="courseHelp" class="form-text">Enter the prerequisites of the course</div>
                        </div>
                            <input type="submit" class="btn btn-primary" value="Save">
                        </form>
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
</style>s