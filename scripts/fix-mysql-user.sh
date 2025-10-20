#!/usr/bin/env bash
set -euo pipefail

# This script ensures the 'student' user exists in the MySQL container and
# grants it privileges on the `basic_db` database, then attempts a PHP
# connection test from the php-apache container.

COMPOSE_FILE="/var/www/html/docker-compose.yml"

if ! command -v docker-compose >/dev/null 2>&1; then
  echo "docker-compose not found. Install docker-compose or use 'docker compose' and run the SQL commands manually."
  exit 1
fi

echo "==> Ensuring database and user exist in mysql container"
docker-compose -f "$COMPOSE_FILE" exec -T mysql mysql -u root -proot <<'SQL'
CREATE DATABASE IF NOT EXISTS basic_db;
CREATE USER IF NOT EXISTS 'student'@'%' IDENTIFIED BY 'student';
GRANT ALL PRIVILEGES ON basic_db.* TO 'student'@'%';
FLUSH PRIVILEGES;
SQL

echo "==> Running PHP connection test from php-apache container"
if docker-compose -f "$COMPOSE_FILE" exec -T php-apache php -r "require '/var/www/html/www/pharmacy/includes/database.php'; echo 'OK';"; then
  echo "PHP connection test: OK"
  exit 0
else
  echo "PHP connection test: FAILED"
  echo "Check mysql container logs: docker-compose -f $COMPOSE_FILE logs mysql" 
  exit 2
fi
