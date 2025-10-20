<?php
// start output buffering so we can safely return JSON for AJAX even if some include outputs
if (!ob_get_level()) { ob_start(); }
// AJAX UPDATE handler (must run before any output)
if (isset($_POST['ajax_update'])) {
  include('includes/database.php');
  $id = (int)$_POST['medicine_id'];
  $g = mysqli_real_escape_string($conn, $_POST['generic_name']);
  $b = mysqli_real_escape_string($conn, $_POST['brand_name']);
  $f = mysqli_real_escape_string($conn, $_POST['dosage_form']);
  $s = mysqli_real_escape_string($conn, $_POST['strength']);
  $e = $_POST['expiration_date'];
  $p = $_POST['unit_price'];
  $q = $_POST['stock_quantity'];
  $r = $_POST['reorder_level'];

  $sql = "UPDATE medicines SET 
        generic_name='$g', brand_name='$b', dosage_form='$f', strength='$s',
        expiration_date='$e', unit_price='$p', stock_quantity='$q', reorder_level='$r'
        WHERE medicine_id=$id";
  $ok = mysqli_query($conn, $sql);
  // clear any accidental output that may have been produced so we return clean JSON
  if (ob_get_length()) { ob_clean(); }
  header('Content-Type: application/json');
  if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Medicine updated', 'id' => $id]);
  } else {
    echo json_encode(['success' => false, 'message' => mysqli_error($conn)]);
  }
  exit;
}

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

  $sql = "INSERT INTO medicines
            (generic_name, brand_name, dosage_form, strength,
             expiration_date, unit_price, stock_quantity, reorder_level)
            VALUES ('$g','$b','$f','$s','$e','$p','$q','$r')";
    mysqli_query($conn,$sql);
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
  mysqli_query($conn,"DELETE FROM medicines WHERE medicine_id=$id");
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

// Support quick action filters: low_stock and expiring
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
if ($filter === 'low_stock') {
  $sql = "SELECT * FROM medicines WHERE stock_quantity <= reorder_level";
  $result = mysqli_query($conn, $sql);
} elseif ($filter === 'expiring') {
  $thirty = date('Y-m-d', strtotime('+30 days'));
  // include already expired items as well
  $sql = "SELECT * FROM medicines WHERE expiration_date <= '$thirty'";
  $result = mysqli_query($conn, $sql);
}
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
    /* expired items: make row and expiry text stand out */
    .table tbody tr.table-danger td { background-color: rgba(220,53,69,0.06) !important; }
    .text-expired { color: #a71d2a !important; font-weight: 600; }
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
                $row_class = $stock_class;
                $today = new DateTime();
                $expiry = new DateTime($row['expiration_date']);
                if ($expiry < $today) {
                  // already expired
                  $expiry_class = 'text-expired';
                  // add bootstrap-like danger row class
                  $row_class = trim(($row_class . ' table-danger'));
                } else {
                  $diff = $today->diff($expiry);
                  if ($diff->days <= 30) {
                    $expiry_class = 'text-expiring';
                  }
                }
              ?>
              <tr class="<?= $row_class ?>">
                <td class="text-center"><?= $row['medicine_id'] ?></td>
                <td class="cell-generic"><?= htmlspecialchars($row['generic_name']) ?></td>
                <td class="cell-brand"><?= htmlspecialchars($row['brand_name']) ?></td>
                <td class="cell-form"><?= htmlspecialchars($row['dosage_form']) ?></td>
                <td class="cell-strength"><?= htmlspecialchars($row['strength']) ?></td>
                <td class="cell-expiration <?= $expiry_class ?>"><?= $row['expiration_date'] ?></td>
                <td class="cell-price" data-order="<?= $row['unit_price'] ?>">$<?= number_format($row['unit_price'], 2) ?></td>
                <td class="cell-stock" data-order="<?= $row['stock_quantity'] ?>"><?= $row['stock_quantity'] ?></td>
                <td class="cell-reorder"><?= $row['reorder_level'] ?></td>
                <td class="text-center">
                  <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-primary btn-edit" data-id="<?= $row['medicine_id'] ?>" title="Edit">
                      <i class="fas fa-edit"></i>
                    </button>
                    <a href="?delete=<?= $row['medicine_id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this medicine?')" 
                       class="btn btn-danger" title="Delete">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>

              <!-- inline edit handled via DataTables child row to avoid column-count mismatch -->
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

      // Inline edit using DataTables child row
      function makeEditFormHtml(id, rowData) {
        // rowData is an object mapping field names
        var html = '<form class="inline-edit-form d-flex gap-2" data-id="' + id + '">';
        html += '<input type="text" name="generic_name" class="form-control form-control-sm" style="width:18%" value="' + $('<div>').text(rowData.generic_name).html() + '">';
        html += '<input type="text" name="brand_name" class="form-control form-control-sm" style="width:18%" value="' + $('<div>').text(rowData.brand_name).html() + '">';
        html += '<input type="text" name="dosage_form" class="form-control form-control-sm" style="width:12%" value="' + $('<div>').text(rowData.dosage_form).html() + '">';
        html += '<input type="text" name="strength" class="form-control form-control-sm" style="width:10%" value="' + $('<div>').text(rowData.strength).html() + '">';
        html += '<input type="date" name="expiration_date" class="form-control form-control-sm" style="width:12%" value="' + $('<div>').text(rowData.expiration_date).html() + '">';
        html += '<input type="number" step="0.01" name="unit_price" class="form-control form-control-sm" style="width:8%" value="' + rowData.unit_price + '">';
        html += '<input type="number" name="stock_quantity" class="form-control form-control-sm" style="width:8%" value="' + rowData.stock_quantity + '">';
        html += '<input type="number" name="reorder_level" class="form-control form-control-sm" style="width:8%" value="' + rowData.reorder_level + '">';
        html += '<div class="ms-2">';
        html += '<button type="button" class="btn btn-sm btn-success btn-save">Save</button> ';
        html += '<button type="button" class="btn btn-sm btn-secondary btn-cancel">Cancel</button>';
        html += '</div>';
        html += '</form>';
        return html;
      }

      $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var $btn = $(this);
        // find DataTable row
        var dtRow = null;
        table.rows().every(function() {
          var r = this.node();
          var first = $(r).find('td:first').text().trim();
          if (first == id) { dtRow = this; return false; }
        });
        if (!dtRow) return;
        // if child shown, close it
        if (dtRow.child.isShown()) {
          dtRow.child.hide();
          return;
        }
        // build rowData
        var rowNode = $(dtRow.node());
        var rowData = {
          generic_name: rowNode.find('.cell-generic').text().trim(),
          brand_name: rowNode.find('.cell-brand').text().trim(),
          dosage_form: rowNode.find('.cell-form').text().trim(),
          strength: rowNode.find('.cell-strength').text().trim(),
          expiration_date: rowNode.find('.cell-expiration').text().trim(),
          unit_price: rowNode.find('.cell-price').attr('data-order') || '0',
          stock_quantity: rowNode.find('.cell-stock').attr('data-order') || '0',
          reorder_level: rowNode.find('.cell-reorder').text().trim() || ''
        };
        var formHtml = makeEditFormHtml(id, rowData);
        dtRow.child(formHtml).show();
        // scroll
        $('html, body').animate({ scrollTop: $(dtRow.node()).offset().top - 120 }, 200);
      });

      // cancel
      $(document).on('click', '.btn-cancel', function() {
        var $form = $(this).closest('form.inline-edit-form');
        var id = $form.data('id');
        table.rows().every(function() {
          var r = $(this.node()).find('td:first').text().trim();
          if (r == id) { this.child.hide(); return false; }
        });
      });

      // save
      $(document).on('click', '.btn-save', function() {
        var $form = $(this).closest('form.inline-edit-form');
        var id = $form.data('id');
        var data = $form.serializeArray();
        data.push({name: 'ajax_update', value: 1});
        data.push({name: 'medicine_id', value: id});

        $.post(window.location.href, data, function(resp) {
          if (resp && resp.success) {
            // update DataTable row cells
            table.rows().every(function() {
              var first = $(this.node()).find('td:first').text().trim();
              if (first == id) {
                var $r = $(this.node());
                $r.find('.cell-generic').text($form.find('[name="generic_name"]').val());
                $r.find('.cell-brand').text($form.find('[name="brand_name"]').val());
                $r.find('.cell-form').text($form.find('[name="dosage_form"]').val());
                $r.find('.cell-strength').text($form.find('[name="strength"]').val());
                $r.find('.cell-expiration').text($form.find('[name="expiration_date"]').val());
                var price = parseFloat($form.find('[name="unit_price"]').val()) || 0;
                $r.find('.cell-price').text('$' + price.toFixed(2)).attr('data-order', price);
                var stock = parseInt($form.find('[name="stock_quantity"]').val()) || 0;
                $r.find('.cell-stock').text(stock).attr('data-order', stock);
                $r.find('.cell-reorder').text($form.find('[name="reorder_level"]').val() || '');
                this.child.hide();
                table.rows().invalidate().draw(false);
                return false;
              }
            });
          } else {
            alert('Update failed: ' + (resp && resp.message ? resp.message : 'unknown'));
          }
        }, 'json').fail(function(xhr) {
          alert('Request failed: ' + xhr.responseText);
        });
      });
    });
  </script>
</body>
</html>
