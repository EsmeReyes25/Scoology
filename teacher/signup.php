<?php 
    require '../connection.php';
    $message = '';
    if(!empty($_POST['name']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {
        if($_POST['password'] === $_POST['repassword']){
            $sql = 'INSERT INTO teachers (teacher_name, teacher_lastname, teacher_email, teacher_password) VALUES (:name, :lastname, :email, :password)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':lastname', $_POST['lastname']);
            $stmt->bindParam(':email', $_POST['email']);
            $newPass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $newPass);
        
            if ($stmt->execute()) {
                $message = 'Successfully created a new teacher';
            } else {
                $message = 'Something went wrong';
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
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <title>Sign up to Scoology as teacher</title>
</head>
<body class="body-sign">
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
                <a href="../teacher/login.php" class="btn">Login</a>
            </span>
            <span> Are you a student?
                <a href="../teacher/signup.php" class="btn">Sign up as student</a>
            </span>
            <form action="../teacher/signup.php" method="post">
                <input type="text" name="name" placeholder="Enter your name">
                <input type="text" name="lastname" placeholder="Enter your lastname">
                <input type="email" name="email" placeholder="Enter your email">
                <input type="password" name="password" placeholder="Enter your password">
                <input type="password" name="repassword" placeholder="Confirm your password">
                <input type="submit" class="btn-form" value="Register">
            </form>
        </div>
    </div>
</body>
</html>