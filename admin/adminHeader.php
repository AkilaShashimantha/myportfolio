<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="adminDashboard.php">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="adminNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='adminDashboard.php') echo ' active'; ?>" href="adminDashboard.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='adminProjects.php') echo ' active'; ?>" href="adminProjects.php">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='adminContactForm.php') echo ' active'; ?>" href="adminContactForm.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="adminLogout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>