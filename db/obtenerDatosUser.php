<?php
include_once './conect.php';
header('Content-Type: application/json');

if (!$pdo) {
    echo json_encode(["estado" => "error", "mensaje" => "Sin conexión a DB"]);
    exit;
} 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["estado" => "error", "mensaje" => "Método inválido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || empty($data['id_user'])) {
    echo json_encode(["estado" => "error", "mensaje" => "Datos inválidos"]);
    exit;
}

try {

    $stmt = $pdo->prepare("SELECT  FROM usuarios WHERE nombre = :nombre LIMIT 1");
    $stmt->execute(['nombre' => $nombre]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(["estado" => "error", "mensaje" => "Dato no encontrado en la base de datos"]);
        exit;
    }

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Dato encontrado",
        "id" => $row['id'],
        "nombre" => $row['nombre']
    ]);
    exit;

} catch (PDOException $e) {
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error de base de datos",
        "detalle" => $e->getMessage()
    ]);
    exit;
}
?>
