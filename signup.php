<?php
require 'connection.php';
$message_s = '';
$message_e = '';
if (!empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['age']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {
    if ($_POST['password'] === $_POST['repassword']) {
        if (!empty($_POST['role']) && $_POST['role'] === 'student') {
            $sql = 'INSERT INTO students (student_name, student_lastname, student_email, student_password, student_age) VALUES (:name, :lastname, :email, :password, :age)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);
            $stmt->bindParam(':age', $_POST['age']);
            $stmt->bindParam(':email', $_POST['email']);
            $newPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $newPass);

            if ($stmt->execute()) {
                $message_e = '';
                $message_s = 'You have successfully registered as student';
            } else {
                $message_s = '';
                $message_e = 'Something went wrong';
            }
        } else if (!empty($_POST['role']) && $_POST['role'] === 'teacher') {
            $sql = 'INSERT INTO teachers (teacher_name, teacher_lastname, teacher_email, teacher_password) VALUES (:name, :lastname, :email, :password)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);
            $stmt->bindParam(':email', $_POST['email']);
            $newPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $newPass);

            if ($stmt->execute()) {
                $message_e = '';
                $message_s = 'You have successfully registered as teacher';
            } else {
                $message_s = '';
                $message_e = 'Something went wrong';
            }
        } else {
            $message_s = '';
            $message_e = 'Please select your role';
        }
    } else {
        $message_s = '';
        $message_e = 'Passwords do not match';
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
    <title>Sign up to Scoology</title>
</head>

<body class="body-index">
    <script type="module" src="js/index.js"></script>

    <?php if (!empty($message_e)) : ?>
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
    <?php if (!empty($message_s)) : ?>
        <div class="row w-100">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </symbol>
                    </svg>
                    <div class="alert alert-success d-flex align-items-center w-75" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>
                            <?= $message_s; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="container w-75 rounded">
        <div class="row align-items-stretch">
            <div class="col bg-sign d-lg-block">
            </div>
            <!-- <div class="col"> -->
            <div class="col bg-light px-5" style="padding-top: 25px">
                <h2 class="text-center mb-4">Signup please</h2>
                <form action="signup.php" method="post">
                    <div class="mb-2 d-flex align-items-center">
                        <span class="mx-2">Are you a student or a teacher?</span>
                        <select class="mx-3" name="role" id="roleSelect">
                            <option value="">Select</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <input class="form-control" type="text" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <input class="form-control" type="text" name="lastname" placeholder="Enter your lastname" required>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <input class="form-control" type="number" name="age" id="ageField" placeholder="Enter your age" required>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <input class="form-control" type="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <input class="form-control" type="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="mb-2 d-flex align-items-center">
                        <input class="form-control" type="password" name="repassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="row d-flex justify-content-center" style="margin-top: 23px">
                        <!-- <input type="submit" class="btn-form btn-outline-primary" value="Login"> -->
                        <input type="submit" class="btn btn-color w-50" value="Register">
                    </div>
                    <div class="my-1 d-flex justify-content-center">
                        <span style="margin-top: -5px"> or
                            <a href="login.php" style="text-decoration: underline;" class="btn">Login</a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>