<?php
require('includes/database.php');

// Get quick statistics
$total_medicines = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM medicines"))['count'];
$low_stock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM medicines WHERE stock_quantity <= reorder_level"))['count'];

// Get expiring medicines (already expired or within the next 30 days)
$today = date('Y-m-d');
$thirty_days = date('Y-m-d', strtotime('+30 days'));
$expiring = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM medicines WHERE expiration_date <= '$thirty_days'"))['count'];

// Get recent activity
$recent = mysqli_query($conn, "SELECT * FROM medicines ORDER BY medicine_id DESC LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - MedCare Pharmacy</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <i class="fas fa-clinic-medical fa-lg me-2"></i>
        <span class="fw-bold">MedCare Pharmacy</span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item mx-1">
            <a class="nav-link active px-3 rounded-pill" href="index.php">
              <i class="fas fa-home me-1"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link px-3 rounded-pill" href="medicines.php">
              <i class="fas fa-pills me-1"></i> Medicines
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link px-3 rounded-pill" href="users.php">
              <i class="fas fa-users me-1"></i> Users
            </a>
          </li>
          <li class="nav-item mx-1 d-none d-lg-block">
            <div class="vr bg-light opacity-25 h-100 mx-2"></div>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link px-3 rounded-pill" href="profile.php">
              <i class="fas fa-user-circle me-1"></i> Profile
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col">
        <h2 class="h3 mb-4">Dashboard Overview</h2>
      </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                  <i class="fas fa-pills fa-2x text-primary"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Total Medicines</h6>
                <h3 class="mb-0"><?= $total_medicines ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-warning bg-opacity-10 p-3 rounded">
                  <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Low Stock Items</h6>
                <h3 class="mb-0"><?= $low_stock ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-danger bg-opacity-10 p-3 rounded">
                  <i class="fas fa-calendar-times fa-2x text-danger"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Expiring Soon</h6>
                <h3 class="mb-0"><?= $expiring ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions and Recent Activity -->
    <div class="row mb-4">
      <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="fas fa-bolt me-1"></i> Quick Actions
            </h6>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <a href="medicines.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Add New Medicine
              </a>
              <a href="medicines.php?filter=low_stock" class="btn btn-warning">
                <i class="fas fa-exclamation-circle me-1"></i> View Low Stock Items
              </a>
              <a href="medicines.php?filter=expiring" class="btn btn-danger">
                <i class="fas fa-clock me-1"></i> View Expiring Items
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
              <i class="fas fa-history me-1"></i> Recent Activity
            </h6>
          </div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              <?php while($med = mysqli_fetch_assoc($recent)): ?>
              <div class="list-group-item px-0">
                <div class="d-flex w-100 justify-content-between">
                  <h6 class="mb-1"><?= htmlspecialchars($med['generic_name']) ?></h6>
                  <small class="text-muted">ID: <?= $med['medicine_id'] ?></small>
                </div>
                <p class="mb-1">
                  Stock: <?= $med['stock_quantity'] ?> | 
                  Price: $<?= number_format($med['unit_price'], 2) ?>
                </p>
              </div>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer bg-light mt-auto py-3">
    <div class="container">
      <div class="text-center">
        <span class="text-muted">&copy; 2025 MedCare Pharmacy System. All rights reserved.</span>
        <div class="mt-2">
          <a href="#" class="text-decoration-none text-muted mx-2">Privacy Policy</a>
          <a href="#" class="text-decoration-none text-muted mx-2">Terms of Service</a>
          <a href="#" class="text-decoration-none text-muted mx-2">Contact Us</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
