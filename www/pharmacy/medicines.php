<?php
include('includes/database.php');

// ADD
if (isset($_POST['add'])) {
    $g = mysqli_real_escape_string($conn, $_POST['generic_name']);
    $b = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $f = mysqli_real_escape_string($conn, $_POST['dosage_form']);
    $s = mysqli_real_escape_string($conn, $_POST['strength']);
    $e = $_POST['expiration_date'];
    $p = $_POST['unit_price'];
    $q = $_POST['stock_quantity'];
    $r = $_POST['reorder_level'];

    $sql = "INSERT INTO Medicines
            (generic_name, brand_name, dosage_form, strength,
             expiration_date, unit_price, stock_quantity, reorder_level)
            VALUES ('$g','$b','$f','$s','$e','$p','$q','$r')";
    mysqli_query($conn,$sql);
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM Medicines WHERE medicine_id=$id");
}

// SEARCH
$keyword = '';
if (isset($_GET['q'])) {
    $keyword = mysqli_real_escape_string($conn,$_GET['q']);
    $sql = "SELECT * FROM medicines
            WHERE generic_name LIKE '%$keyword%'
               OR brand_name LIKE '%$keyword%'";
} else {
    $sql = "SELECT * FROM medicines";
}
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Medicines Management - MedCare Pharmacy</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="assets/css/buttons.bootstrap5.min.css">
  <link rel="stylesheet" href="assets/css/fixedHeader.bootstrap5.min.css">
  <style>
    .dt-buttons .btn { margin-right: 5px; }
    .table tbody tr.low-stock { background-color: rgba(255, 193, 7, 0.1) !important; }
    .text-expiring { color: #dc3545 !important; }
    .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
      background-color: var(--bs-primary);
      border-color: var(--bs-primary);
    }
    .btn-group-sm > .btn { padding: 0.25rem 0.5rem; }
  </style>
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
            <a class="nav-link px-3 rounded-pill" href="index.php">
              <i class="fas fa-home me-1"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link active px-3 rounded-pill" href="medicines.php">
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
        <h2 class="h3 mb-4">Medicines Management</h2>
        <form method="get" class="mb-4">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" name="q" placeholder="Search medicines..." value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Add Medicine Form -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus-circle"></i> Add New Medicine</h6>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-prescription-bottle-medical"></i> Generic Name</label>
              <input type="text" class="form-control" name="generic_name" placeholder="Enter generic name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-trademark"></i> Brand Name</label>
              <input type="text" class="form-control" name="brand_name" placeholder="Enter brand name">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-tablets"></i> Dosage Form</label>
              <input type="text" class="form-control" name="dosage_form" placeholder="Enter dosage form">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-weight"></i> Strength</label>
              <input type="text" class="form-control" name="strength" placeholder="Enter strength">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-calendar"></i> Expiration Date</label>
              <input type="date" class="form-control" name="expiration_date">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-tag"></i> Unit Price</label>
              <input type="number" step="0.01" class="form-control" name="unit_price" placeholder="Enter price">
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-boxes"></i> Stock Quantity</label>
              <input type="number" class="form-control" name="stock_quantity" placeholder="Enter stock quantity">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label"><i class="fas fa-level-down-alt"></i> Reorder Level</label>
              <input type="number" class="form-control" name="reorder_level" placeholder="Enter reorder level">
            </div>
          </div>

          <div class="text-end">
            <button type="submit" name="add" class="btn btn-primary">
              <i class="fas fa-plus me-2"></i> Add Medicine
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Medicines Table -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list"></i> Medicines List</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="medicinesTable" class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th class="text-center"><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-prescription-bottle-medical"></i> Generic Name</th>
                <th><i class="fas fa-trademark"></i> Brand Name</th>
                <th><i class="fas fa-pills"></i> Form</th>
                <th><i class="fas fa-weight"></i> Strength</th>
                <th><i class="fas fa-calendar"></i> Expiration</th>
                <th><i class="fas fa-tag"></i> Price</th>
                <th><i class="fas fa-boxes"></i> Stock</th>
                <th><i class="fas fa-level-down-alt"></i> Reorder</th>
                <th class="text-center"><i class="fas fa-cogs"></i> Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($result)): 
                $stock_class = '';
                if ($row['stock_quantity'] <= $row['reorder_level']) {
                  $stock_class = 'low-stock';
                }
                
                $expiry_class = '';
                $today = new DateTime();
                $expiry = new DateTime($row['expiration_date']);
                $diff = $today->diff($expiry);
                if ($diff->days <= 30) {
                  $expiry_class = 'text-expiring';
                }
              ?>
              <tr class="<?= $stock_class ?>">
                <td class="text-center"><?= $row['medicine_id'] ?></td>
                <td><?= htmlspecialchars($row['generic_name']) ?></td>
                <td><?= htmlspecialchars($row['brand_name']) ?></td>
                <td><?= htmlspecialchars($row['dosage_form']) ?></td>
                <td><?= htmlspecialchars($row['strength']) ?></td>
                <td class="<?= $expiry_class ?>"><?= $row['expiration_date'] ?></td>
                <td data-order="<?= $row['unit_price'] ?>">$<?= number_format($row['unit_price'], 2) ?></td>
                <td data-order="<?= $row['stock_quantity'] ?>"><?= $row['stock_quantity'] ?></td>
                <td><?= $row['reorder_level'] ?></td>
                <td class="text-center">
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="edit.php?id=<?= $row['medicine_id'] ?>" 
                       class="btn btn-primary" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="?delete=<?= $row['medicine_id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this medicine?')" 
                       class="btn btn-danger" title="Delete">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
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
  </div>

  <!-- Scripts -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/dataTables.buttons.min.js"></script>
  <script src="assets/js/buttons.bootstrap5.min.js"></script>
  <script src="assets/js/jszip.min.js"></script>
  <script src="assets/js/pdfmake.min.js"></script>
  <script src="assets/js/vfs_fonts.js"></script>
  <script src="assets/js/buttons.html5.min.js"></script>
  <script src="assets/js/buttons.print.min.js"></script>
  <script src="assets/js/buttons.colVis.min.js"></script>
  <script src="assets/js/dataTables.fixedHeader.min.js"></script>
  
  <script>
    $(document).ready(function() {
      var table = $('#medicinesTable').DataTable({
        pageLength: 10,
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
          {
            extend: 'collection',
            text: '<i class="fas fa-download me-1"></i> Export',
            className: 'btn-primary btn-sm',
            buttons: [
              {
                extend: 'excel',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                className: 'btn-sm',
                exportOptions: { columns: ':not(:last-child)' }
              },
              {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn-sm',
                exportOptions: { columns: ':not(:last-child)' }
              },
              {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                className: 'btn-sm',
                exportOptions: { columns: ':not(:last-child)' }
              }
            ]
          },
          {
            extend: 'colvis',
            text: '<i class="fas fa-columns me-1"></i> Columns',
            className: 'btn-primary btn-sm'
          }
        ],
        fixedHeader: {
          header: true,
          headerOffset: $('.navbar').height()
        },
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search medicines...",
          lengthMenu: "_MENU_ per page",
          info: "Showing _START_ to _END_ of _TOTAL_ medicines",
          paginate: {
            first: '<i class="fas fa-angle-double-left"></i>',
            previous: '<i class="fas fa-angle-left"></i>',
            next: '<i class="fas fa-angle-right"></i>',
            last: '<i class="fas fa-angle-double-right"></i>'
          }
        },
        columnDefs: [
          { orderable: false, targets: -1 },
          { className: "text-center", targets: [0, -1] }
        ],
        order: [[0, 'asc']]
      });

      // Move the search box to the existing search form
      $('#medicinesTable_filter').hide();
      $('.input-group input[name="q"]').on('keyup', function() {
        table.search(this.value).draw();
      });

      // Make the table header fixed on scroll
      $(window).scroll(function() {
        table.fixedHeader.adjust();
      });
    });
  </script>
</body>
</html>
