<?php 
    require '../connection.php';
    $course_id = $_GET['id'];

    $query = "DELETE FROM courses WHERE courses.course_id = $course_id";
    $stmt = $conn->prepare($query);
    if ($stmt->execute()) {
        header("Location: ../teacher/home.php");
    } else {
        echo 'Something went wrong';
    }
?>