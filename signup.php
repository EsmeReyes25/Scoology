<?php 
    require 'connection.php';
    $message = '';
    if(!empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['age']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {
        if($_POST['password'] === $_POST['repassword']){
            if(!empty($_POST['role']) && $_POST['role'] === 'student'){
                $sql = 'INSERT INTO students (student_name, student_lastname, student_email, student_password, student_age) VALUES (:name, :lastname, :email, :password, :age)';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $_POST['name']);
                $stmt->bindParam(':lastname', $_POST['lastname']);
                $stmt->bindParam(':age', $_POST['age']);
                $stmt->bindParam(':email', $_POST['email']);
                $newPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $newPass);
            
                if ($stmt->execute()) {
                    $message = 'You have successfully registered as student';
                } else {
                    $message = 'Something went wrong';
                }
            } else if(!empty($_POST['role']) && $_POST['role'] === 'teacher'){
                $sql = 'INSERT INTO teachers (teacher_name, teacher_lastname, teacher_email, teacher_password) VALUES (:name, :lastname, :email, :password)';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $_POST['name']);
                $stmt->bindParam(':lastname', $_POST['lastname']);
                $stmt->bindParam(':email', $_POST['email']);
                $newPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $newPass);
            
                if ($stmt->execute()) {
                    $message = 'You have successfully registered as teacher';
                } else {
                    $message = 'Something went wrong';
                }
            } else {
                $message = 'Please select your role';
            }
        } else {
            $message = 'Passwords do not match';
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
    <title>Sign up to Scoology</title>
</head>
<body class="body-sign">
    <script type="module" src="js/index.js"></script>

    <div>
        <?php if(!empty($message)): ?>
            <p>
                <?= $message; ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="box">
        <div class="container">
            <h1>Signup please</h1>
            <span> or
                <a href="login.php" class="btn">Login</a>
            </span>
            <form action="signup.php" method="post">
                <label for="role">Are you a student or a teacher?</label>
                <select name="role" id="roleSelect" required>
                    <option value="">Select</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>
                <input type="text" name="name" placeholder="Enter your name" required>
                <input type="text" name="lastname" placeholder="Enter your lastname" required>
                <input type="number" name="age" id="ageField" placeholder="Enter your age" required>
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" placeholder="Enter your password" required>
                <input type="password" name="repassword" placeholder="Confirm your password" required>
                <input type="submit" class="btn-form" value="Register">
            </form>
        </div>
    </div>
</body>
</html>