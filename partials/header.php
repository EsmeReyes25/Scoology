<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="./style.css">
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
        <a href="#">
          <h1>Scoology</h1>
        </a>
      </div>
      <div class="d-flex align-items-center" style="margin-right: 40px">
        <div>
          <i class="fa-solid fa-message fa-shake"></i>
        </div>
        <div>
          <i class="fa-solid fa-bell fa-shake"></i>
        </div>
        <div class="dropdown">
          <i class="nav-link fa-solid fa-user dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          </i>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Edit profile</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Log out</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <script src="./js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<style>
a{
    text-decoration: none;
}

li{
    list-style: none;
    margin-top: 12px;
}

#sidebar {
    max-width: 264px;
    min-width: 264px;
    transition: all 0.35s ease-in-out;
    height: 100vh;
}

#sidebar.collapsed{
    margin-left: -264px;
}

.main {
    display: flex;
    flex-direction: column;
    width: 100%;
    overflow: hidden;
    transition: all 0.35s ease-in-out;
}

.sidebar-logo {
    padding: 1.15rem 1.5rem;
}

.sidebar-logo a {
    font-size: 1.25rem;
    font-weight: 600px;
}

i{
    font-size: 1.5rem;
    padding: .625rem 1.625rem;
}

.dropdown-menu{
    min-width: 8rem;
}

i:hover{
    cursor: pointer;
}
</style>