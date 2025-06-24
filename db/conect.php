<?php

function connectDB() {
    $host = 'localhost';
    $db   = 'agennutri'; // Asegúrate de que este sea el nombre correcto de tu DB
    $user = 'root';      // ¡CAMBIA ESTO! Usa un usuario de DB con menos privilegios en producción
    $pass = '';          // ¡CAMBIA ESTO! Usa una contraseña fuerte en producción
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    

    try {
        $pdo = new PDO($dsn, $user, $pass);
        return $pdo;
    } catch (\PDOException $e) {
        echo "<script>console.log('Error de conexión a la base de datos: " . $e->getMessage() . "');</script>";
    }
}