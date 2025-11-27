<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>High Court Kaduna - Age Declaration System</title>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Roboto', Arial, sans-serif;
    background: #f8f9fa;
    margin: 0;
    overflow-x: hidden;
}

/* Navbar */
.navbar {
    background-color: #002147 !important;
}
.navbar-brand, .nav-link {
    color: #fff !important;
    font-weight: 600;
}
.nav-link:hover {
    color: #ffc107 !important;
}

/* Hero Section */
.hero {
    height: 70vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 0 20px;
    background: linear-gradient(270deg, #002147, #004080, #0066cc, #002147);
    background-size: 800% 800%;
    animation: gradientBG 15s ease infinite;
    color: white;
}

@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.hero h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 15px;
    animation: fadeInDown 1.5s ease forwards;
}

.hero p {
    font-size: 1.3rem;
    margin-bottom: 25px;
    animation: fadeInUp 1.8s ease forwards;
}

/* Hero Buttons */
.btn-hero {
    margin: 10px;
    padding: 12px 30px;
    font-size: 1.2rem;
    transition: transform 0.3s, box-shadow 0.3s;
}
.btn-hero:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

/* About Cards */
.card {
    transition: transform 0.5s, box-shadow 0.5s;
}
.card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

/* Footer */
footer {
    background-color: #002147;
    color: white;
    text-align: center;
    padding: 15px;
}

/* Animations */
@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-40px);}
    100% { opacity: 1; transform: translateY(0);}
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(40px);}
    100% { opacity: 1; transform: translateY(0);}
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <!-- <img src="assets/images/logo.png" alt="Court Logo" style="height:50px; margin-right:10px;"> -->
      High Court Kaduna
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="login.php">Admin Login</a></li>
        <li class="nav-item"><a class="nav-link" href="verify.php">Verify Declaration</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <h1>High Court Kaduna - Age Declaration System</h1>
  <p>Simplifying Age Declarations for Applicants and Court Staff.</p>
  <div>
    <a href="login.php" class="btn btn-warning btn-lg btn-hero">Admin Login</a>
    <a href="verify.php" class="btn btn-light btn-lg btn-hero">Verify Declaration</a>
  </div>
</section>

<!-- About Section -->
<section class="container my-5">
  <div class="row text-center">
    <div class="col-md-6 mb-4">
      <div class="card shadow-sm h-100 p-4">
        <div class="card-body">
          <h5 class="card-title">For Applicants</h5>
          <p class="card-text">Submit your age declaration requests securely through the High Court Kaduna system. Fast, accurate, and official.</p>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card shadow-sm h-100 p-4">
        <div class="card-body">
          <h5 class="card-title">For Court Staff</h5>
          <p class="card-text">Manage, approve, and generate official Declarations efficiently through a modern digital portal.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  &copy; <?php echo date('Y'); ?> High Court of Justice, Kaduna State. All Rights Reserved.
</footer>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
