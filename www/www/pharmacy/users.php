
<?php
include('includes/database.php');

// Create Users table if it doesn't exist
$create_table_sql = file_get_contents('sql/create_users_table.sql');
mysqli_query($conn, $create_table_sql);

// ADD
if (isset($_POST['add'])) {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $f = mysqli_real_escape_string($conn, $_POST['full_name']);
    $r = mysqli_real_escape_string($conn, $_POST['role']);

    mysqli_query($conn,"INSERT INTO Users (username, full_name, role, date_created)
                        VALUES ('$u','$f','$r', NOW())");
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM Users WHERE user_id=$id");
}

// SEARCH
$keyword = '';
if (isset($_GET['q'])) {
    $keyword = mysqli_real_escape_string($conn,$_GET['q']);
    $sql = "SELECT * FROM Users
            WHERE username LIKE '%$keyword%'
               OR full_name LIKE '%$keyword%'";
} else {
    $sql = "SELECT * FROM Users";
}
$result = mysqli_query($conn,$sql);

// Get total users count
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM Users"))['count'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Management - MedCare Pharmacy</title>
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
            <a class="nav-link px-3 rounded-pill" href="index.php">
              <i class="fas fa-home me-1"></i> Dashboard
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link px-3 rounded-pill" href="medicines.php">
              <i class="fas fa-pills me-1"></i> Medicines
            </a>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link active px-3 rounded-pill" href="users.php">
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
        <h2 class="h3 mb-4">User Management</h2>
        <form method="get" class="mb-4">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" name="q" placeholder="Search users..." 
                   value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Quick Stats Card -->
    <div class="row mb-4">
      <div class="col-md-4 mb-3">
        <div class="card shadow-sm border-0 h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                  <i class="fas fa-users fa-2x text-primary"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="text-muted mb-1">Total Users</h6>
                <h3 class="mb-0"><?= $total_users ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add User Form -->
    <div class="card shadow-sm mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
          <i class="fas fa-user-plus me-1"></i> Add New User
        </h6>
      </div>
      <div class="card-body">
        <form method="post">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">
                <i class="fas fa-user me-1"></i> Username
              </label>
              <input type="text" class="form-control" name="username" 
                     placeholder="Enter username" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">
                <i class="fas fa-id-card me-1"></i> Full Name
              </label>
              <input type="text" class="form-control" name="full_name" 
                     placeholder="Enter full name" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">
                <i class="fas fa-user-tag me-1"></i> Role
              </label>
              <select class="form-select" name="role">
                <option value="User">User</option>
                <option value="Admin">Admin</option>
                <option value="Manager">Manager</option>
              </select>
            </div>
          </div>
          <div class="text-end">
            <button type="submit" name="add" class="btn btn-primary">
              <i class="fas fa-plus-circle me-1"></i> Add User
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
          <i class="fas fa-users me-1"></i> Users List
        </h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th><i class="fas fa-hashtag me-1"></i> ID</th>
                <th><i class="fas fa-user me-1"></i> Username</th>
                <th><i class="fas fa-id-card me-1"></i> Full Name</th>
                <th><i class="fas fa-user-tag me-1"></i> Role</th>
                <th><i class="fas fa-calendar me-1"></i> Date Created</th>
                <th><i class="fas fa-cogs me-1"></i> Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $row['user_id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['full_name']) ?></td>
                <td>
                  <span class="badge bg-<?= $row['role'] === 'Admin' ? 'danger' : 
                                         ($row['role'] === 'Manager' ? 'warning' : 'primary') ?>">
                    <?= htmlspecialchars($row['role']) ?>
                  </span>
                </td>
                <td><?= $row['date_created'] ?></td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="edit_user.php?id=<?= $row['user_id'] ?>" 
                       class="btn btn-sm btn-primary" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="?delete=<?= $row['user_id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this user?')" 
                       class="btn btn-sm btn-danger" title="Delete">
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

  <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
