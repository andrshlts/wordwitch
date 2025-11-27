-- create test database for Laravel tests
CREATE DATABASE IF NOT EXISTS wordwitch_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant all privileges to the Laravel user
GRANT ALL PRIVILEGES ON wordwitch_test.* TO 'laravel'@'%';
FLUSH PRIVILEGES;