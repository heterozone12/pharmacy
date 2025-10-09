<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic PHP & MySQL Environment</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px;
            line-height: 1.6;
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
        .status {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info {
            background: #e2e3e5;
            border: 1px solid #d6d8db;
            color: #383d41;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .links {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007cba;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .btn:hover { background: #005a8b; }
        .code {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            border-left: 4px solid #007cba;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Basic PHP & MySQL Environment</h1>
            <p>Simple setup for learning PHP and MySQL</p>
        </div>

        <div class="status">
            <h3>✅ Environment Status</h3>
            <p><strong>PHP Version:</strong> <?= phpversion() ?></p>
            <p><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache' ?></p>
            <?php
            $conn = mysqli_connect("mysql", "root", "root", "basic_db");
            if ($conn) {
                echo "<p><strong>Database:</strong> ✅ Connected to MySQL</p>";
                mysqli_close($conn);
            } else {
                echo "<p><strong>Database:</strong> ⏳ Starting up...</p>";
            }
            ?>
        </div>

        <div class="links">
            <a href="/db-test.php" class="btn">🔍 Test Database</a>
            <a href="/simple-crud.php" class="btn">📝 Simple CRUD</a>
            <a href="/phpinfo.php" class="btn">📋 PHP Info</a>
            <a href="http://localhost:8080" target="_blank" class="btn">�️ phpMyAdmin</a>
        </div>

        <div class="info">
            <h3>🔧 Database Connection</h3>
            <div class="code">
<strong>Database Details:</strong>
Host: mysql
Database: basic_db
Username: root (or student)
Password: root (or student)
            </div>
        </div>

        <div class="info">
            <h3>� Sample PHP Code</h3>
            <div class="code">
&lt;?php
// Connect to database
$pdo = new PDO("mysql:host=mysql;dbname=basic_db", "root", "root");

// Simple query
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

foreach ($users as $user) {
    echo $user['name'] . " - " . $user['email'] . "&lt;br&gt;";
}
?&gt;
            </div>
        </div>

        <div class="info">
            <h3>� What You Can Learn</h3>
            <ul>
                <li>Basic PHP syntax and programming</li>
                <li>Database connections with MySQLi</li>
                <li>Simple CRUD operations</li>
                <li>HTML and PHP integration</li>
                <li>Basic web development workflow</li>
            </ul>
        </div>

        <div class="info">
            <h3>� File Structure</h3>
            <p>Place your PHP files in <code>/var/www/html/</code></p>
            <p>Access phpMyAdmin for database management</p>
            <p>Use the terminal for any command-line tasks</p>
        </div>

        <footer style="text-align: center; margin-top: 30px; color: #666;">
            <hr>
            <p>Basic PHP & MySQL Environment • Generated on <?= date('Y-m-d H:i:s') ?></p>
        </footer>
    </div>
</body>
</html>
