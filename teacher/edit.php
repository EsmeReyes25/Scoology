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
    <title>Edit course</title>
</head>
<body>
    <div>
        <div>
            <form action="../teacher/edit.php?id=<?php echo $course_id?>" method="post">
                <label for="name">Name of the course</label>
                <input type="text" name="name" value="<?php echo $course['name']?>" placeholder="Enter the name of the course" required>
                <label for="description">Description</label>
                <input type="text" name="description" value="<?php echo $course['description']?>" placeholder="Enter a brief description of the course" required>
                <label for="prerequisites">Prerequisites (optional)</label>
                <input type="text" name="prerequisites" value="<?php echo $course['prereq']?>" placeholder="Enter the prerequisites of the course">
                <input type="submit" class="btn btn-primary" value="Save">
            </form>
        </div>
    </div>
</body>
</html>