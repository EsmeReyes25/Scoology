<?php 
    session_start();
    require '../connection.php';
    $course_id = $_GET['id'];
    $student_id = NULL;

    if (isset($_SESSION['student_id'])) {
        $query = "SELECT * FROM students WHERE student_id = :id";
        $registro = $conn->prepare($query);
        $registro->bindParam(':id', $_SESSION['student_id']);
        $registro->execute();
        $resultado_student = $registro->fetch(PDO::FETCH_ASSOC);
        $student = null;
        if(count($resultado_student) > 0){
            $student = $resultado_student;
            $student_id = $student['student_id'];
        }
    } 

    $currentDate = date('Y-m-d');

    $query = "INSERT INTO register (reg_course_id, reg_student_id, reg_date) VALUES (:course_id, :student_id, :date)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':date', $currentDate);
    if($stmt->execute()){
        header("Location: ../student/course.php?id=$course_id");
    } else {
        echo "Something went wrong";
    }
?>