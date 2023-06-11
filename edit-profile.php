<?php 
    session_start();
    require 'connection.php';
    if (isset($_SESSION['student_id'])) {
        $query = "SELECT * FROM students WHERE student_id = :id";
        $registro = $conn->prepare($query);
        $registro->bindParam(':id', $_SESSION['student_id']);
        $registro->execute();
        $resultado = $registro->fetch(PDO::FETCH_ASSOC);
        $student = null;
        if(count($resultado) > 0){
            $student = $resultado;
            $student_id = $student['student_id'];
        }
    } else if (isset($_SESSION['teacher_id'])) {
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

    $message_s = '';
    $message_e = '';
    if (!empty($_POST['name']) && !empty($_POST['lastname'])) {
        if (!empty($student)) {
            $sql = "UPDATE students SET student_name = :name, student_lastname = :lastname, student_age = :age WHERE student_id = $student_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);
            $stmt->bindParam(':age', $_POST['age']);

            if ($stmt->execute()) {
                $message_e = '';
                $message_s = 'Data updated successfully';
            } else {
                $message_s = '';
                $message_e = 'Something went wrong';
            }
        } else if (!empty($teacher)) {
            $sql = "UPDATE teachers SET teacher_name = :name, teacher_lastname = :lastname WHERE teacher_id = $teacher_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);

            if ($stmt->execute()) {
                $message_e = '';
                $message_s = 'Data updated successfully';
            } else {
                $message_s = '';
                $message_e = 'Something went wrong';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="icon" href="assets/images/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Edit Profile</title>
</head>

<body class="body-index">
    <!-- Incluir la barra de navegación y la barra lateral -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Incluir la barra de navegación -->
                <?php include 'partials/header.php'; ?>
            </div>
        </div>
        <div class="row">
            <!-- Incluir la barra lateral -->
            <?php if (!empty($student)) : ?>
                <?php include 'partials/student-sidebar.html'; ?>
            <?php elseif (!empty($teacher)) : ?>
                <?php include 'partials/teacher-sidebar.html'; ?>
            <?php endif; ?>
            <div class="col-8">
                <!-- Contenido principal -->
                <?php if (!empty($message_e)): ?>
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <div class="alert alert-danger d-flex align-items-center w-75" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                    <div>
                                        <?= $message_e; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($message_s)): ?>
                    <div class="row w-100">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </symbol>
                                </svg>
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                    <div>
                                        <?=$message_s; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="container w-75 rounded">
                    <div class="row align-items-stretch">
                        <div class="col bg d-lg-block"></div>
                        <div class="col bg-light px-5" style="padding-top: 25px">
                            <?php if(!empty($student)): ?>
                                <form action="edit-profile.php" method="post">
                                    <div class="mb-2 d-flex align-items-center">
                                        <input class="form-control" type="text" name="name" value="<?php echo $student['student_name']?>" placeholder="Enter your name" required>
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <input class="form-control" type="text" name="lastname" value="<?php echo $student['student_lastname']?>" placeholder="Enter your lastname" required>
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <input class="form-control" type="number" name="age" value="<?php echo $student['student_age']?>" placeholder="Enter your age" required>
                                    </div>
                                    <div class="row d-flex justify-content-center" style="margin-top: 23px">
                                        <input type="submit" class="btn btn-outline-dark w-50" value="Save">
                                    </div>
                                </form>
                            <?php elseif(!empty($teacher)): ?>
                                <form action="edit-profile.php" method="post">
                                    <div class="mb-2 d-flex align-items-center">
                                        <input class="form-control" type="text" name="name" value="<?php echo $teacher['teacher_name']?>" placeholder="Enter your name" required>
                                    </div>
                                    <div class="mb-2 d-flex align-items-center">
                                        <input class="form-control" type="text" name="lastname" value="<?php echo $teacher['teacher_lastname']?>" placeholder="Enter your lastname" required>
                                    </div>
                                    <div class="row d-flex justify-content-center" style="margin-top: 23px">
                                        <input type="submit" class="btn btn-outline-dark w-50" value="Save">
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>