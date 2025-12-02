<?php
include('db.php');

$message = '';
$declaration = null;

if(isset($_POST['verify'])){
    $token = trim($_POST['token']);

    if(empty($token)){
        $message = "Please enter a declaration token.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM declarations WHERE qr_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $declaration = $result->fetch_assoc();
        } else {
            $message = "Declaration not found for the provided token.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Verify Declaration - High Court Kaduna</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #002147, #004080, #0066cc);
    min-height: 100vh;
    font-family: 'Segoe UI', Arial, sans-serif;
    color: #fff;
}
.card {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}
.btn-verify {
    background-color: #ffc107;
    color: #002147;
    font-weight: 600;
}
.btn-verify:hover {
    background-color: #e6b800;
    color: #002147;
}
.btn-home {
    margin-top: 10px;
    background-color: #002147;
    color: #ffc107;
    font-weight: 600;
}
.btn-home:hover {
    background-color: #004080;
    color: #ffc107;
}
img {
    border-radius: 5px;
}
.alert-success p {
    color: #000;
}
</style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card p-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4 text-primary">Verify Age Declaration</h3>

        <!-- Form -->
        <form method="POST">
            <div class="mb-3">
                <label for="token" class="form-label text-dark">Enter Declaration Token</label>
                <input type="text" class="form-control" id="token" name="token" placeholder="e.g. a1b2c3d4e5" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" name="verify" class="btn btn-verify btn-lg">Verify</button>
            </div>
        </form>

        <!-- Back to Home Button -->
        <div class="d-grid">
            <a href="index.php" class="btn btn-home btn-lg">Back to Home</a>
        </div>

        <hr class="my-4">

        <!-- Message -->
        <?php if($message): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Display Details -->
        <?php if($declaration): ?>
            <div class="alert alert-success">
                <h5>Declaration Found!</h5>

                <p><strong>Applicant Name:</strong> <?= htmlspecialchars($declaration['applicant_name']) ?></p>
                <p><strong>DOB:</strong> <?= $declaration['dob'] ?></p>
                <p><strong>LGA:</strong> <?= htmlspecialchars($declaration['lga']) ?></p>
                <p><strong>Gender:</strong> <?= $declaration['gender'] ?></p>

                <p><strong>Father's Full Name:</strong> <?= htmlspecialchars($declaration['father_fullname']) ?></p>
                <p><strong>Mother's Full Name:</strong> <?= htmlspecialchars($declaration['mother_fullname']) ?></p>
                <p><strong>Place of Birth:</strong> <?= htmlspecialchars($declaration['place_of_birth']) ?></p>
                <p><strong>State of Origin:</strong> <?= htmlspecialchars($declaration['state_of_origin']) ?></p>

                <p><strong>Declarant:</strong> <?= htmlspecialchars($declaration['declarant_name']) ?></p>

                <p><strong>Token:</strong> <?= htmlspecialchars($declaration['qr_token']) ?></p>

                <?php if(!empty($declaration['photo']) && file_exists('uploads/'.$declaration['photo'])): ?>
                    <p><strong>Photo:</strong></p>
                    <img src="uploads/<?= $declaration['photo'] ?>" alt="Applicant Photo" style="width:100px;">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
