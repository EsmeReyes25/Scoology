<?php 
    session_start();
    if (isset($_SESSION['student_id'])) {
        $query = "SELECT * FROM students WHERE student_id = :id";
        $registro = $conn->prepare($query);
        $registro->bindParam(':id', $_SESSION['student_id']);
        $registro->execute();
        $resultado = $registro->fetch(PDO::FETCH_ASSOC);
        $student = null;
        if(count($resultado) > 0){
            $student = $resultado;
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
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
  <div class="main">
    <nav class="d-flex justify-content-between navbar navbar-expand px-3 border-bottom">
      <div>
        <button class="btn" type="button">
          <i class="fa-solid fa-bars lead"></i>
        </button>
      </div>
      <div class="sidebar-logo">
        <?php if(!empty($student)): ?>
          <a href="../student/home.php">
            <h1>Scoology</h1>
          </a>
        <?php elseif(!empty($teacher)): ?>
          <a href="../teacher/home.php">
            <h1>Scoology</h1>
          </a>
        <?php endif; ?>
      </div>
      <div class="d-flex align-items-center" style="margin-right: 40px">
        <div>
          <i class="fa-solid fa-message fa-shake"></i>
        </div>
        <div>
          <i class="fa-solid fa-bell fa-shake"></i>
        </div>
        <div class="dropdown user-drop">
          <i class="user-icon nav-link fa-solid fa-user dropdown-toggle" id="navbarDropdown" role="button" aria-expanded="false"></i>
          <ul class="drop-menu hide" aria-labelledby="navbarDropdown">
            <li><a class="menu-option dropdown-item" href="../edit-profile.php">Edit profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="menu-option dropdown-item" href="../logout.php">Log out</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="../js/script.js"></script>
  <script src="../js/dropdown.js"></script>
</body>
</html>