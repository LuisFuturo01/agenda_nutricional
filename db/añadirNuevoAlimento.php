<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once './conect.php';
header('Content-Type: application/json');

if ($pdo) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $data = json_decode(file_get_contents("php://input"), true);

        // Log para depurar
        file_put_contents("debug.log", "Petición recibida\n", FILE_APPEND);
        file_put_contents("debug.log", print_r($data, true), FILE_APPEND);

        // Validación mínima
        if (!$data || !isset($data['alimento'])) {
            echo json_encode(["estado" => "error", "mensaje" => "Datos incompletos"]);
            exit;
        }

        // 1. Insertar en alimentos
        $stmt = $pdo->prepare("INSERT INTO alimentos (nombre, calorias, proteinas, grasas, carbohidratos) 
            VALUES (:nombre, :calorias, :proteinas, :grasas, :carbohidratos)");
        $stmt->execute([
            ':nombre' => $data['alimento'],
            ':calorias' => $data['calorias'],
            ':proteinas' => $data['proteinas'],
            ':grasas' => $data['grasas'],
            ':carbohidratos' => $data['carbohidratos']
        ]);

        $idAlimento = $pdo->lastInsertId();

        // 2. Insertar en registro_alimentacion
        $stmt = $pdo->prepare("INSERT INTO registro_alimentacion (usuario_id, alimento_id, cantidad_gramos, fecha) 
            VALUES (:usuario_id, :alimento_id, :cantidad_gramos, :fecha)");
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

    } else {
        echo json_encode(["estado" => "error", "mensaje" => "Método no permitido"]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "Sin conexión"]);
}
