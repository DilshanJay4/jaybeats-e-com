<?php

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name_val = getenv('DB_NAME') ?: 'jaybeats_db';
$user_name = getenv('DB_USER') ?: 'root';
$user_password = getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'mysql';

$db_name = "mysql:host={$db_host};dbname={$db_name_val};charset=utf8mb4";

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die('Database connection failed. Please try again later.');
}
