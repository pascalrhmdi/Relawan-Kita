<?php
$host = 'localhost';
$admin = 'root';
$password = '';
$db = 'relawan_kita';

// Data Source Name untuk fungsi PDO
$dsn = "mysql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $admin, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage());
}

require_once 'crud.php';
require_once 'user.php';
$crud = new crud($pdo);
$user = new user($pdo);

// auto add user admin kalau belum ada admin
$user->insertUser("admin@admin.com", "admin", "Admin", "admin", "Laki-laki", "Griya Asri 1", "08986866871", "");