<?php
include('includes/auth_check.php');
include('includes/header.php');
include('db.php');

$error = [];
$success = '';

$applicant_name = $dob = $lga = $gender = $declarant_name = '';
$father_fullname = $mother_fullname = $place_of_birth = $state_of_origin = '';

if(isset($_POST['submit'])){

    // Collect and sanitize input
    $applicant_name   = trim($_POST['applicant_name']);
    $dob              = $_POST['dob'];
    $lga              = trim($_POST['lga']);
    $gender           = $_POST['gender'];
    $declarant_name   = trim($_POST['declarant_name']);
    $father_fullname  = trim($_POST['father_fullname']);
    $mother_fullname  = trim($_POST['mother_fullname']);
    $place_of_birth   = trim($_POST['place_of_birth']);
    $state_of_origin  = trim($_POST['state_of_origin']);

    // Validation
    if(empty($applicant_name)) $error[] = "Applicant name is required.";
    if(empty($dob)) $error[] = "Date of birth is required.";
    if(empty($lga)) $error[] = "LGA is required.";
    if(empty($gender)) $error[] = "Gender is required.";
    if(empty($father_fullname)) $error[] = "Father's full name is required.";
    if(empty($mother_fullname)) $error[] = "Mother's full name is required.";
    if(empty($place_of_birth)) $error[] = "Place of birth is required.";
    if(empty($state_of_origin)) $error[] = "State of origin is required.";
    if(empty($declarant_name)) $error[] = "Declarant name is required.";

    // Generate unique token
    $token = bin2hex(random_bytes(5));

    // Handle photo upload
    $photo = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE){
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
                $error[] = 'Error uploading photo.';
            }
        } else {
            $error[] = 'Invalid photo format. Only JPG, JPEG, PNG allowed.';
        }
    }

    // Insert into database if no errors
    if(empty($error)){
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
            // Clear form values
            $applicant_name = $dob = $lga = $gender = $declarant_name = '';
            $father_fullname = $mother_fullname = $place_of_birth = $state_of_origin = '';
        } else {
            $error[] = "Database error: " . $stmt->error;
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">New Declaration</h2>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach($error as $err) echo "<li>$err</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Applicant Name</label>
                    <input type="text" class="form-control" name="applicant_name" value="<?= htmlspecialchars($applicant_name) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($dob) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">LGA</label>
                    <input type="text" class="form-control" name="lga" value="<?= htmlspecialchars($lga) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender" required>
                        <option value="">-- Select Gender --</option>
                        <option value="Male" <?= $gender=='Male'?'selected':'' ?>>Male</option>
                        <option value="Female" <?= $gender=='Female'?'selected':'' ?>>Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Father's Full Name</label>
                    <input type="text" class="form-control" name="father_fullname" value="<?= htmlspecialchars($father_fullname) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mother's Full Name</label>
                    <input type="text" class="form-control" name="mother_fullname" value="<?= htmlspecialchars($mother_fullname) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Place of Birth</label>
                    <input type="text" class="form-control" name="place_of_birth" value="<?= htmlspecialchars($place_of_birth) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">State of Origin</label>
                    <input type="text" class="form-control" name="state_of_origin" value="<?= htmlspecialchars($state_of_origin) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Declarant Name</label>
                    <input type="text" class="form-control" name="declarant_name" value="<?= htmlspecialchars($declarant_name) ?>" required>
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
