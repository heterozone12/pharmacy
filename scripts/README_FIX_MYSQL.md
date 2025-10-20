Fix MySQL user and test PHP connection

Usage (run on the host where docker-compose is available):

```
cd /var/www/html
chmod +x scripts/fix-mysql-user.sh
./scripts/fix-mysql-user.sh
```

What it does:
- Ensures `basic_db` exists
- Creates `student`@`%` with password `student` if missing and grants privileges
- Runs a PHP test from the `php-apache` container that includes `www/pharmacy/includes/database.php`

If `docker-compose` is not available use the SQL snippet below inside your MySQL server:

```
CREATE DATABASE IF NOT EXISTS basic_db;
CREATE USER IF NOT EXISTS 'student'@'%' IDENTIFIED BY 'student';
GRANT ALL PRIVILEGES ON basic_db.* TO 'student'@'%';
FLUSH PRIVILEGES;
```
