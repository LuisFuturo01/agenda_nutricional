<?php
$mysqlUser = 'root';
$mysqlPass = '';
$mysqlHost = '127.0.0.1';
$mysqlPort = '3306';

$basePath = 'D:/xampp/mysql/data';  // Cambia esto si tu ruta es distinta

$mysqli = new mysqli($mysqlHost, $mysqlUser, $mysqlPass, '', $mysqlPort);
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$databases = scandir($basePath);
foreach ($databases as $db) {
    if ($db === '.' || $db === '..' || !is_dir("$basePath/$db")) continue;

    echo "▶ Restaurando base de datos: $db\n";
    $mysqli->query("CREATE DATABASE IF NOT EXISTS `$db`");

    $tables = scandir("$basePath/$db");
    foreach ($tables as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) !== 'frm') continue;

        $table = pathinfo($file, PATHINFO_FILENAME);
        $ibdPath = "$basePath/$db/$table.ibd";
        $frmPath = "$basePath/$db/$table.frm";

        if (!file_exists($ibdPath)) continue;

        echo "  → Restaurando tabla: $table\n";

        // Paso 1: Crear tabla dummy (estructura mínima)
        $createSQL = "CREATE TABLE `$db`.`$table` (id INT) ENGINE=InnoDB;";
        $mysqli->query($createSQL);

        // Paso 2: Eliminar .ibd generado automáticamente
        unlink($ibdPath); // Borra el nuevo

        // Paso 3: Copiar el ibd antiguo (ya debe estar ahí en realidad)

        // Paso 4: IMPORT TABLESPACE
        $importSQL = "ALTER TABLE `$db`.`$table` IMPORT TABLESPACE;";
        if (!$mysqli->query($importSQL)) {
            echo "    ⚠️ Error al importar $table: " . $mysqli->error . "\n";
        } else {
            echo "    ✅ Importado correctamente\n";
        }
    }
}

$mysqli->close();
