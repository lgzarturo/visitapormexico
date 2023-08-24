-- Drop the database if it exists
DROP DATABASE IF EXISTS user_products;

-- Create the database with UTF-8mb4 support
CREATE DATABASE user_products CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the newly created database
USE user_products;

-- Drop the users table if it exists
DROP TABLE IF EXISTS users;

-- Create the users table with auto-increment id
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    status VARCHAR(50),
    creation_date DATE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Drop the products table if it exists
DROP TABLE IF EXISTS products;

-- Create the products table with auto-increment id
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200),
    description TEXT,
    price DECIMAL(10, 2)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Insert 10 sample users
INSERT INTO users (name, email, status, creation_date)
VALUES
    ('User 1', 'user1@example.com', 'active', '2023-08-23'),
    ('User 2', 'user2@example.com', 'inactive', '2023-08-23'),
    ('User 3', 'user3@example.com', 'active', '2023-08-23'),
    ('User 4', 'user4@example.com', 'inactive', '2023-08-23'),
    ('User 5', 'user5@example.com', 'active', '2023-08-23'),
    ('User 6', 'user6@example.com', 'active', '2023-08-23'),
    ('User 7', 'user7@example.com', 'inactive', '2023-08-23'),
    ('User 8', 'user8@example.com', 'active', '2023-08-23'),
    ('User 9', 'user9@example.com', 'inactive', '2023-08-23'),
    ( 'User 10', 'user10@example.com', 'active', '2023-08-23');

-- Insert 20 sample products
INSERT INTO products (title, description, price)
VALUES
    ('Product 1', 'Description of Product 1', 19.99),
    ('Product 2', 'Description of Product 2', 29.99),
    ('Product 3', 'Description of Product 3', 9.99),
    ('Product 4', 'Description of Product 4', 49.99),
    ('Product 5', 'Description of Product 5', 39.99),
    ('Product 6', 'Description of Product 6', 14.99),
    ('Product 7', 'Description of Product 7', 24.99),
    ('Product 8', 'Description of Product 8', 59.99),
    ('Product 9', 'Description of Product 9', 34.99),
    ('Product 10', 'Description of Product 10', 44.99),
    ('Product 11', 'Description of Product 11', 16.99),
    ('Product 12', 'Description of Product 12', 26.99),
    ('Product 13', 'Description of Product 13', 12.99),
    ('Product 14', 'Description of Product 14', 42.99),
    ('Product 15', 'Description of Product 15', 32.99),
    ('Product 16', 'Description of Product 16', 22.99),
    ('Product 17', 'Description of Product 17', 52.99),
    ('Product 18', 'Description of Product 18', 37.99),
    ('Product 19', 'Description of Product 19', 47.99),
    ('Product 20', 'Description of Product 20', 64.99);
