<?php
include('includes/auth_check.php');
include('includes/header.php');
include('db.php');

$error = '';
$success = '';

if(isset($_POST['submit'])){
    $applicant_name   = mysqli_real_escape_string($conn, $_POST['applicant_name']);
    $dob              = $_POST['dob'];
    $lga              = mysqli_real_escape_string($conn, $_POST['lga']);
    $gender           = $_POST['gender'];
    $declarant_name   = mysqli_real_escape_string($conn, $_POST['declarant_name']);
    $father_fullname  = mysqli_real_escape_string($conn, $_POST['father_fullname']);
    $mother_fullname  = mysqli_real_escape_string($conn, $_POST['mother_fullname']);
    $place_of_birth   = mysqli_real_escape_string($conn, $_POST['place_of_birth']);
    $state_of_origin  = mysqli_real_escape_string($conn, $_POST['state_of_origin']);

    // Generate token
    $token = bin2hex(random_bytes(5));

    // Handle photo upload
    $photo = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK){
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg','jpeg','png'];

        if(in_array($fileExt, $allowedExt)){
            $newFileName = time() . '_' . uniqid() . '.' . $fileExt;
            $destPath = 'uploads/' . $newFileName;

            if(!is_dir('uploads')) mkdir('uploads', 0755, true);

            if(move_uploaded_file($fileTmpPath, $destPath)){
                $photo = $newFileName;
            } else {
                $error = 'Error uploading photo.';
            }
        } else {
            $error = 'Invalid photo format. Only JPG, JPEG, PNG allowed.';
        }
    }

    if(!$error){
        $stmt = $conn->prepare("INSERT INTO declarations (
            applicant_name, dob, lga, gender, declarant_name,
            father_fullname, mother_fullname, place_of_birth, state_of_origin,
            photo, qr_token
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssssssssss",
            $applicant_name, $dob, $lga, $gender, $declarant_name,
            $father_fullname, $mother_fullname, $place_of_birth, $state_of_origin,
            $photo, $token
        );

        if($stmt->execute()){
            $success = "Declaration created successfully. Token: <strong>$token</strong>";
        } else {
            $error = "Database error: " . $stmt->error;
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">New H Declaration</h2>

    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Applicant Name</label>
                    <input type="text" class="form-control" name="applicant_name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">LGA</label>
                    <input type="text" class="form-control" name="lga" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Father's Full Name</label>
                    <input type="text" class="form-control" name="father_fullname" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mother's Full Name</label>
                    <input type="text" class="form-control" name="mother_fullname" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Place of Birth</label>
                    <input type="text" class="form-control" name="place_of_birth" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">State of Origin</label>
                    <input type="text" class="form-control" name="state_of_origin" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Declarant Name</label>
                    <input type="text" class="form-control" name="declarant_name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Photo (Optional)</label>
                    <input type="file" class="form-control" name="photo" accept=".jpg,.jpeg,.png">
                </div>

                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-success btn-lg">Submit Declaration</button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
