<?php
include_once './conect.php';

header('Content-Type: application/json');

if ($pdo) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $pdo->prepare("SELECT id, nombre FROM alimentos WHERE nombre LIKE :nombre LIMIT 1");
        $stmt->execute(['nombre' => strtolower($data['nombre'])]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            echo json_encode(["estado" => "no"]);
        } else {
            echo json_encode([
                "estado" => "ok",
                "id" => $row['id'],
                "nombre" => $row['nombre']
            ]);
        }
        exit;
    } else {
        echo json_encode(["estado" => "error", "mensaje" => "Método inválido"]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "Sin conexión a DB"]);
}
?>
