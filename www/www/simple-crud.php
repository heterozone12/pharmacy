<?php
/**
 * Simple CRUD Demo - Basic PHP & MySQL
 */

// Database connection
$conn = mysqli_connect("mysql", "root", "root", "basic_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submissions
$message = '';
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email) VALUES (?, ?)");
                mysqli_stmt_bind_param($stmt, "ss", $_POST['name'], $_POST['email']);
                mysqli_stmt_execute($stmt);
                $message = "✅ User added successfully!";
                mysqli_stmt_close($stmt);
                break;
                
            case 'delete':
                $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "i", $_POST['id']);
                mysqli_stmt_execute($stmt);
                $message = "✅ User deleted successfully!";
                mysqli_stmt_close($stmt);
                break;
        }
    }
}

// Get all users
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple CRUD Demo</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header { 
            text-align: center;
            color: #333;
            border-bottom: 2px solid #007cba;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .form-group { 
            margin-bottom: 15px; 
        }
        label { 
            display: block; 
            margin-bottom: 5px; 
            font-weight: bold; 
        }
        input[type="text"], input[type="email"] { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box;
        }
        .btn { 
            padding: 8px 16px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            text-decoration: none; 
            display: inline-block; 
            margin: 2px; 
        }
        .btn-primary { background: #007cba; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn:hover { opacity: 0.9; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { background-color: #f8f9fa; }
        .message { 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 4px; 
            background: #d4edda; 
            color: #155724; 
            border: 1px solid #c3e6cb; 
        }
        .back-link { margin-bottom: 20px; }
        .code-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007cba;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📝 Simple CRUD Demo</h1>
            <p>Create, Read, Update, Delete with PHP & MySQL</p>
        </div>

        <div class="back-link">
            <a href="/" class="btn btn-primary">← Back to Home</a>
            <a href="http://localhost:8080" target="_blank" class="btn btn-primary">🗃️ phpMyAdmin</a>
        </div>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Add User Form -->
        <h3>➕ Add New User</h3>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Add User</button>
        </form>

        <!-- Users List -->
        <h3>👥 Users List</h3>
        <?php if (empty($users)): ?>
            <p>No users found. Add the first user above!</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['created_at'] ?></td>
                            <td>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Delete this user?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Code Example -->
        <div class="code-section">
            <h3>💻 The Code Behind This Demo</h3>
            <p>Here's how this simple CRUD works:</p>
            <pre><code><?= htmlspecialchars('// 1. Connect to database
$pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");

// 2. Add user (CREATE)
$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->execute([$name, $email]);

// 3. Get all users (READ)
$stmt = $pdo->query("SELECT * FROM users ORDER BY id");
$users = $stmt->fetchAll();

// 4. Delete user (DELETE)
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);') ?></code></pre>
        </div>

        <div class="code-section">
            <h3>📚 What You Learned</h3>
            <ul>
                <li><strong>Database Connection:</strong> Using PDO to connect to MySQL</li>
                <li><strong>Prepared Statements:</strong> Safe way to handle user input</li>
                <li><strong>HTML Forms:</strong> Collecting user data</li>
                <li><strong>PHP Processing:</strong> Handling form submissions</li>
                <li><strong>SQL Operations:</strong> INSERT, SELECT, DELETE queries</li>
            </ul>
        </div>

        <footer style="text-align: center; margin-top: 30px; color: #666;">
            <hr>
            <p>Simple CRUD Demo • Generated on <?= date('Y-m-d H:i:s') ?></p>
        </footer>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
