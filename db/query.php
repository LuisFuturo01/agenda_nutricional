<?php
// query.php

/**
 * Obtiene los datos del usuario de la tabla 'usuarios'.
 * @param PDO $pdo Objeto PDO de la conexión a la base de datos.
 * @param int $user_id ID del usuario.
 * @return array|false Retorna un array asociativo con los datos del usuario o false si no se encuentra.
 */
function getUserData(PDO $pdo, int $user_id) {
    // Columnas de la tabla `usuarios` según agennutri.sql (y asumiendo objetivo_salud añadido)
    $stmt = $pdo->prepare("SELECT id, nombre, correo, contraseña, edad, sexo, altura_cm, objetivo_salud FROM usuarios WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

/**
 * Obtiene el registro más reciente de peso y altura para un usuario de la tabla `control_fisico`.
 * @param PDO $pdo Objeto PDO de la conexión a la base de datos.
 * @param int $user_id ID del usuario.
 * @return array|false Retorna un array asociativo con 'peso_kg' y 'altura_cm' o false si no hay registros.
 */
function getLatestControlFisico(PDO $pdo, int $user_id) {
    // Columnas de la tabla `control_fisico` según agennutri.sql
    $stmt = $pdo->prepare("SELECT peso_kg, altura_cm FROM control_fisico WHERE usuario_id = ? ORDER BY fecha DESC LIMIT 1");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

/**
 * Actualiza el perfil del usuario, incluyendo datos de la tabla 'usuarios' y 'control_fisico'.
 * También maneja el cambio de contraseña.
 * @param PDO $pdo Objeto PDO de la conexión a la base de datos.
 * @param int $user_id ID del usuario.
 * @param string $nombre Nuevo nombre de usuario.
 * @param string $objetivo_salud Nuevo objetivo de salud.
 * @param int|null $edad Nueva edad.
 * @param string|null $sexo Nuevo sexo.
 * @param float|null $altura_cm_user Nueva altura para la tabla 'usuarios'.
 * @param float|null $peso_kg_cf Nuevo peso para la tabla 'control_fisico'.
 * @param float|null $altura_cm_cf Nueva altura para la tabla 'control_fisico'.
 * @param string $current_password Contraseña actual para verificación.
 * @param string $new_password Nueva contraseña.
 * @param string $confirm_new_password Confirmación de la nueva contraseña.
 * @param string $current_hash Hash de la contraseña actual almacenado en la DB (de la tabla `usuarios`).
 * @return array Retorna un array con 'status' ('success' o 'error') y 'message'.
 */
function updateUserProfile(
    PDO $pdo,
    int $user_id,
    string $nombre,
    string $objetivo_salud,
    ?int $edad,
    ?string $sexo,
    ?float $altura_cm_user,
    ?float $peso_kg_cf,
    ?float $altura_cm_cf,
    string $current_password,
    string $new_password,
    string $confirm_new_password,
    string $current_hash // El hash actual de la contraseña del usuario (columna `contraseña`)
) {
    $pdo->beginTransaction();
    $changes_made = false;

    try {
        // 1. Actualizar tabla `usuarios`
        $update_user_fields = [];
        $update_user_values = [];

        // Obtener datos actuales del usuario para comparar
        $current_user_data = getUserData($pdo, $user_id);
        if (!$current_user_data) {
            $pdo->rollBack();
            return ['status' => 'error', 'message' => 'Usuario no encontrado para actualización.'];
        }

        // Comparar y añadir campos a actualizar
        if ($nombre !== $current_user_data['nombre']) {
            $update_user_fields[] = 'nombre = ?';
            $update_user_values[] = $nombre;
            $changes_made = true;
        }
        // Comparar con valor por defecto si 'objetivo_salud' es null en DB o no existe en $current_user_data
        if ($objetivo_salud !== ($current_user_data['objetivo_salud'] ?? '')) {
            $update_user_fields[] = 'objetivo_salud = ?';
            $update_user_values[] = $objetivo_salud;
            $changes_made = true;
        }
        if ($edad !== $current_user_data['edad']) {
            $update_user_fields[] = 'edad = ?';
            $update_user_values[] = $edad;
            $changes_made = true;
        }
        if ($sexo !== $current_user_data['sexo']) {
            $update_user_fields[] = 'sexo = ?';
            $update_user_values[] = $sexo;
            $changes_made = true;
        }
        if ($altura_cm_user !== $current_user_data['altura_cm']) {
            $update_user_fields[] = 'altura_cm = ?';
            $update_user_values[] = $altura_cm_user;
            $changes_made = true;
        }

        // Manejo del cambio de contraseña
        if (!empty($new_password)) { // Si se intenta cambiar la contraseña
            if (empty($current_password)) {
                $pdo->rollBack();
                return ['status' => 'error', 'message' => 'Por favor, introduce tu contraseña actual para cambiarla.'];
            }
            if ($new_password !== $confirm_new_password) {
                $pdo->rollBack();
                return ['status' => 'error', 'message' => 'Las nuevas contraseñas no coinciden.'];
            }
            if (strlen($new_password) < 8) {
                $pdo->rollBack();
                return ['status' => 'error', 'message' => 'La nueva contraseña debe tener al menos 8 caracteres.'];
            }
            // Verificar la contraseña actual contra el hash almacenado
            if (!password_verify($current_password, $current_hash)) {
                $pdo->rollBack();
                return ['status' => 'error', 'message' => 'La contraseña actual es incorrecta.'];
            }

            $update_user_fields[] = 'contraseña = ?'; // Nombre de columna correcto: 'contraseña'
            $update_user_values[] = password_hash($new_password, PASSWORD_DEFAULT);
            $changes_made = true;
        } elseif (!empty($current_password) || !empty($confirm_new_password)) {
             // Si solo se llenó un campo de contraseña y no el 'new_password'
            $pdo->rollBack();
            return ['status' => 'error', 'message' => 'Debes proporcionar la nueva contraseña y confirmarla si deseas cambiarla.'];
        }


        // Ejecutar actualización de `usuarios` si hay campos modificados
        if (!empty($update_user_fields)) {
            $sql = "UPDATE usuarios SET " . implode(', ', $update_user_fields) . " WHERE id = ?";
            $update_user_values[] = $user_id;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($update_user_values);
        }

        // 2. Actualizar tabla `control_fisico` (insertar nuevo registro si hay cambios en peso o altura de control)
        $current_control_fisico = getLatestControlFisico($pdo, $user_id);
        $current_peso_cf = $current_control_fisico['peso_kg'] ?? null;
        $current_altura_cf = $current_control_fisico['altura_cm'] ?? null;

        $control_fisico_changed = false;
        if ($peso_kg_cf !== null && $peso_kg_cf != $current_peso_cf) {
            $control_fisico_changed = true;
        }
        if ($altura_cm_cf !== null && $altura_cm_cf != $current_altura_cf) {
            $control_fisico_changed = true;
        }

        if ($control_fisico_changed) {
            $final_peso_cf = ($peso_kg_cf !== null) ? $peso_kg_cf : $current_peso_cf;
            $final_altura_cf = ($altura_cm_cf !== null) ? $altura_cm_cf : $current_altura_cf;

            $stmt = $pdo->prepare("INSERT INTO control_fisico (usuario_id, peso_kg, altura_cm, fecha) VALUES (?, ?, ?, CURDATE())");
            $stmt->execute([$user_id, $final_peso_cf, $final_altura_cf]);
            $changes_made = true;
        }

        if ($changes_made) {
            $pdo->commit();
            return ['status' => 'success', 'message' => '¡Perfil actualizado exitosamente!'];
        } else {
            $pdo->rollBack(); // No se hicieron cambios, así que revertimos cualquier operación
            return ['status' => 'info', 'message' => 'No se realizaron cambios en el perfil.'];
        }

    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Database error in updateUserProfile: " . $e->getMessage());
        return ['status' => 'error', 'message' => 'Error de base de datos al actualizar el perfil. Por favor, inténtalo de nuevo.'];
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("General error in updateUserProfile: " . $e->getMessage());
        return ['status' => 'error', 'message' => 'Ha ocurrido un error inesperado.'];
    }
}