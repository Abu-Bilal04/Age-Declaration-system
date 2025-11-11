<?php
// Start session only if not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>High Court Kaduna - Age Declaration System</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Optional custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Arial, sans-serif;
    }
    .navbar {
      background-color: #002147 !important;
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 600;
    }
    .nav-link:hover {
      text-decoration: underline;
      color: #ffc107 !important;
    }
    .court-logo {
      height: 50px;
      margin-right: 10px;
    }
    .page-container {
      padding: 40px;
    }
  </style>
</head>
<body>

<!-- ======= Navbar ======= -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
  <div class="container-fluid px-4">
    <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
      <!-- <img src="assets/images/logo.png" alt="Court Logo" class="court-logo"> -->
      <span>High Court of Justice, Kaduna State</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <?php if(isset($_SESSION['admin'])): ?>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="new_declaration.php">New Declaration</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</nav>

<!-- ======= Page Content Container ======= -->
<div class="page-container container">
