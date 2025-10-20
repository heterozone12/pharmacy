-- Basic Database Setup
CREATE DATABASE IF NOT EXISTS basic_db;
USE basic_db;

-- Simple users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO users (name, email) VALUES 
('John Doe', 'john@example.com'),
('Jane Smith', 'jane@example.com'),
('Student One', 'student1@school.edu');

-- Create student user account
CREATE USER IF NOT EXISTS 'student'@'%' IDENTIFIED BY 'student';
GRANT ALL PRIVILEGES ON basic_db.* TO 'student'@'%';
FLUSH PRIVILEGES;

-- Show success message
SELECT 'Basic PHP & MySQL Environment Ready!' AS message;
