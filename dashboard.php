<?php
include('includes/auth_check.php'); // Protect page
include('includes/header.php');
include('db.php');

// Fetch declaration stats
$totalDeclarations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM declarations"))['total'];
$recentDeclarations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM declarations WHERE created_at >= NOW() - INTERVAL 7 DAY"))['total'];
?>

<div class="container-fluid mt-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Dashboard - H Declarations</h2>
        <a href="new_declaration.php" class="btn btn-success btn-lg shadow-sm">
            <i class="bi bi-plus-circle"></i> New Declaration
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Declarations</h5>
                    <h2 class="card-text"><?= $totalDeclarations ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Recent (7 days)</h5>
                    <h2 class="card-text"><?= $recentDeclarations ?></h2>
                </div>
            </div>
        </div>
        <!-- Add more cards if needed -->
    </div>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Applicant Name or Token...">
    </div>

    <!-- Declarations Table -->
    <?php
    $result = mysqli_query($conn, "SELECT * FROM declarations ORDER BY created_at DESC");
    if(mysqli_num_rows($result) > 0):
    ?>
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle" id="declarationsTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Applicant Name</th>
                    <th>DOB</th>
                    <th>LGA</th>
                    <th>Token</th>
                    <th>Issued On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['applicant_name']) ?></td>
                    <td><?= $row['dob'] ?></td>
                    <td><?= htmlspecialchars($row['lga']) ?></td>
                    <td><?= $row['qr_token'] ?></td>
                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="generate_pdf.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> View PDF
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div class="alert alert-info shadow-sm">No declarations found. Click "New Declaration" to add one.</div>
    <?php endif; ?>
</div>

<!-- Footer included -->
<?php include('includes/footer.php'); ?>

<!-- Optional: Bootstrap Icons & Search Filter -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script>
    // Simple client-side search/filter
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function(){
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('#declarationsTable tbody tr');
        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const token = row.cells[4].textContent.toLowerCase();
            if(name.includes(filter) || token.includes(filter)){
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
