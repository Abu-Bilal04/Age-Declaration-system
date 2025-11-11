<?php
session_start();
include('db.php');

// Redirect if already logged in
if(isset($_SESSION['admin'])){
    header("Location: dashboard.php");
    exit();
}

$error = "";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    if(mysqli_num_rows($query) > 0){
        $admin = mysqli_fetch_assoc($query);
        if(password_verify($password, $admin['password'])){
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login - High Court Kaduna</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #002147, #004080, #0066cc);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', Arial, sans-serif;
}
.card {
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    animation: fadeIn 1s ease forwards;
}
.card-header {
    background-color: #002147;
    color: #ffc107;
    font-weight: 700;
    text-align: center;
    font-size: 1.3rem;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}
.btn-login {
    background-color: #ffc107;
    color: #002147;
    font-weight: 600;
    transition: 0.3s;
}
.btn-login:hover {
    background-color: #e6b800;
    color: #002147;
}
.error-msg {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
@keyframes fadeIn {
    0% {opacity: 0; transform: translateY(-20px);}
    100% {opacity: 1; transform: translateY(0);}
}
</style>
</head>
<body>

<div class="card">
  <div class="card-header">
    Admin Login
  </div>
  <div class="card-body">
    <?php if($error != ""): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
      </div>
      <div class="d-grid">
        <button type="submit" name="login" class="btn btn-login btn-lg">Login</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
