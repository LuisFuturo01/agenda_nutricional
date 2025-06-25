<?php

$host = 'localhost';
$db   = 'agennutri'; 
$user = 'root';      
$pass = '';          
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    return $pdo;
} catch (\PDOException $e) {
    echo "<script>console.log('Error de conexión a la base de datos ');</script>";
    return null;
}
