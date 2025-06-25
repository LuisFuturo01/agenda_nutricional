<?php
    include_once './conect.php';

if ($pdo) {
    if (!$data || !isset($data['id_user'])) {
        echo json_encode(["estado" => "error", "mensaje" => "Datos inválidos"]);
        exit;
    }
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        $data = json_decode(file_get_contents("php://input"), true);
        echo $data;
    }
    $stmt = $pdo->prepare("INSERT INTO registro_alimentacion (usuario_id, alimento_id, cantidad_gramos, fecha) 
    VALUES (:usuario_id, :alimento_id, :cantidad_gramos, :fecha)");
    $stmt->execute([
        ':usuario_id' => $data['id_user'],
        ':alimento_id' => $data['id_alimento'],
        ':cantidad_gramos' => $data['cantidad'],
        ':fecha' => $data['fecha']
    ]);

    
}else echo "<script>console.log('Error de conexión a la base de datos ');</script>";