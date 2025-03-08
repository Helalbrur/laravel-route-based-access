<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-Dl9Q2vO7DkW8udkdDw7a3WX6qc/uauYIc8Jj1zQ4+4/6s6sE6UusJ6UZT0T25U6" crossorigin="anonymous">


  <!-- Custom CSS -->
  <style>
    /* Navbar */

#navbar {
    margin-bottom: 1rem;
  }

  .navbar-brand {
    font-weight: bold;
  }

  .navbar-toggler:focus {
    outline: none;
  }

  .dropdown-menu {
    background-color: #f8f9fa;
    border: none;
  }

  .dropdown-item:hover {
    background-color: #e9ecef;
  }

  /* Left menu */

  .left-menu {
    width: 240px;
    padding: 20px;
    margin-top: 56px;
    position: fixed;
    left: 0;
    bottom: 0;
    top: 0;
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
    z-index: 1;
  }


  #left-menu.open {
    left: 0;
  }

  .menu-item {
    position: relative;
  }

  .menu-item a {
    display: block;
    padding: 0.5rem 1rem;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
  }

  .menu-item a:hover {
    background-color: #212529;
  }

  .sublist {
    padding-left: 1.5rem;
  }

  .sublist .arrow {
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
  }

  .sublist .sublist {
    display: none;
  }

  .sublist.show .sublist {
    display: block;
  }

  .sublist.show .arrow::after {
    content: "\f078";
  }

  .arrow::after {
    font-family: "Font Awesome 5 Free";
    content: "\f077";
    font-weight: 900;
    display: inline-block;
    margin-left: 0.5rem;
    font-size: 0.75rem;
    transform: rotate(90deg);
  }

  /* Main content */

  #main-content {
    margin-left: 250px;
    padding: 1rem;
  }

  /* Footer */

  #footer {
    margin-top: 1rem;
    padding: 0.5rem;
    background-color: #f8f9fa;
    text-align: center;
  }

  </style>

</head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="navbar">
        <div class="container">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                User
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
            </li>
            </ul>
        </div>
        </div>
    </nav>

    <!-- /.navbar -->
    <div class="container-fluid">
        <div class="row">
    <!-- left -->
    <nav class="col-md-2 bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
              </a>
            </li>
            <li class="nav-item submenu">
              <a href="#" class="nav-link">
                <i class="fas fa-list"></i>
                <span>Menus</span>
                <span class="arrow"></span>
              </a>
              <ul class="nav flex-column">
                <li class="nav-item submenu">
                  <a href="#" class="nav-link">
                    <span>Menu 1</span>
                    <span class="arrow"></span>
                  </a>
                  <ul class="nav flex-column">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <span>Menu 2</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

    <!-- /.left -->

     <!-- Page Content -->
     <main role="main" class="col-md-10">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <h1>Testing</h1>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <footer class="bg-light py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p>&copy; 2023 Your Company. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a href="#">Terms of Use</a></li>
            <li class="list-inline-item">⋅</li>
            <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const leftMenu = document.getElementById('left-menu');

        menuToggle.addEventListener('click', function() {
        leftMenu.classList.toggle('open');
        });

        const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

        dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('show');
        });
        });


    </script>
    <!-- REQUIRED SCRIPTS -->

</body>
</html>
