<?php
include_once './conect.php';
header('Content-Type: application/json');

if (!$pdo) {
    echo json_encode(["estado" => "error", "mensaje" => "Sin conexión a la base de datos"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["estado" => "error", "mensaje" => "Método no permitido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (
    !$data ||
    !isset($data['alimento']) ||
    !isset($data['calorias']) ||
    !isset($data['proteinas']) ||
    !isset($data['grasas']) ||
    !isset($data['carbohidratos']) ||
    !isset($data['id_user']) ||
    !isset($data['cantidad']) ||
    !isset($data['fecha'])
) {
    echo json_encode(["estado" => "error", "mensaje" => "Datos incompletos"]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO alimentos (nombre, calorias, proteinas, grasas, carbohidratos) 
        VALUES (:nombre, :calorias, :proteinas, :grasas, :carbohidratos)
    ");
    $stmt->execute([
        ':nombre' => $data['alimento'],
        ':calorias' => $data['calorias'],
        ':proteinas' => $data['proteinas'],
        ':grasas' => $data['grasas'],
        ':carbohidratos' => $data['carbohidratos']
    ]);

    $idAlimento = $pdo->lastInsertId();

    $stmt = $pdo->prepare("
        INSERT INTO registro_alimentacion (usuario_id, alimento_id, cantidad_gramos, fecha) 
        VALUES (:usuario_id, :alimento_id, :cantidad_gramos, :fecha)
    ");
    $stmt->execute([
        ':usuario_id' => $data['id_user'],
        ':alimento_id' => $idAlimento,
        ':cantidad_gramos' => $data['cantidad'],
        ':fecha' => $data['fecha']
    ]);

    echo json_encode([
        "estado" => "ok",
        "mensaje" => "Alimento añadido correctamente"
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
