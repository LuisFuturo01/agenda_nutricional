<?php
include_once './conect.php';
header('Content-Type: application/json');

if (!$pdo) {
    echo json_encode(["estado" => "error", "mensaje" => "Error de conexión a la base de datos"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["estado" => "error", "mensaje" => "Método no permitido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data ||
    !isset($data['id_user']) ||
    !isset($data['id_alimento']) ||
    !isset($data['cantidad']) ||
    !isset($data['fecha'])
) {
    echo json_encode(["estado" => "error", "mensaje" => "Datos inválidos"]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO registro_alimentacion (usuario_id, alimento_id, cantidad_gramos, fecha) 
        VALUES (:usuario_id, :alimento_id, :cantidad_gramos, :fecha)
    ");
    $stmt->execute([
        ':usuario_id' => $data['id_user'],
        ':alimento_id' => $data['id_alimento'],
        ':cantidad_gramos' => $data['cantidad'],
        ':fecha' => $data['fecha']
    ]);

    echo json_encode(["estado" => "ok", "mensaje" => "Alimento registrado correctamente"]);
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
