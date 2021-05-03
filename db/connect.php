<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'relawankita';
    $charset = 'utm8mb4';

    // Data Source Name untuk fungsi PDO
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $PDO = new PDO($dsn, $user, $password);
        echo "Hello Database, Connected Succesfully";
    } catch (PDOException $e) {
        echo "<h3 class='text-center'>Database Connection failed<h3>";
        throw new PDOException($e->getMessage());
    }

    
?>