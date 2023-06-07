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
  <aside id="sidebar">
    <div>
      <ul class="sidebar-nav">
        <li class="sidebar-header">
          Select an action
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="fa-solid fa-house pe-2 lead"></i>
            Home
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="fa-solid fa-house pe-2 lead"></i>
            My courses
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="fa-solid fa-house pe-2 lead"></i>
            About
          </a>
        </li>
        <li class="sidebar-item">
          <a href="#" class="sidebar-link">
            <i class="fa-solid fa-house pe-2 lead"></i>
            Calendar
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <script src="./js/script.js"></script>
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

.sidebar-nav {
    padding: 0;
}

.sidebar-header {
    /* color de letra - color:brown */
    font-size: 25px;
    padding: 1.5rem 1.5rem .375rem;
}

a.sidebar-link {
    padding: .625rem 1.625rem;
    /* color de letra e icono - color: brown */
    position: relative;
    display: block;
    font-size: 1.5rem;
}

i{
    font-size: 1.5rem;
    padding: .625rem 1.625rem;
}

i:hover{
    cursor: pointer;
}

</style>