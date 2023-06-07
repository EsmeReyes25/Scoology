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

    if(!empty($_POST['name']) && !empty($_POST['description'])) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add course</title>
</head>
<body>
    <div>
        <div>
            <form action="../teacher/add-course.php" method="post">
                <label for="name">Name of the course</label>
                <input type="text" name="name" placeholder="Enter the name of the course" required>
                <label for="description">Description</label>
                <input type="text" name="description" placeholder="Enter a brief description of the course" required>
                <label for="prerequisites">Prerequisites (optional)</label>
                <input type="text" name="prerequisites" placeholder="Enter the prerequisites of the course">
                <input type="submit" class="btn btn-primary" value="Add course">
            </form>
        </div>
    </div>
</body>
</html>