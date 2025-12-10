<?php
// DB connection using PDO for PHP 8.1
$db_host = '127.0.0.1';
$db_name = 'resort_booking';
$db_user = 'root';
$db_pass = ''; // change if needed

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    exit('Database connection failed: ' . $e->getMessage());
}
?>
