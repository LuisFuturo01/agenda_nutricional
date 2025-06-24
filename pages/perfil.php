<?php
session_start();

// Simulación de usuario logueado para desarrollo.
// En un entorno de producción, asegúrate de que el usuario esté realmente autenticado.
if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión activa
    // header('Location: login.php');
    // exit();
    $_SESSION['user_id'] = 1; // **PARA PRUEBAS: Asume que el usuario con ID 1 está logueado.**
}

require_once '../db/conect.php'; // Incluye el archivo de conexión a la DB, ruta corregida
require_once '../db/query.php';  // Incluye el archivo de funciones de consulta, ruta corregida

$user_id = $_SESSION['user_id'];
$message = '';
$message_type = ''; // 'success', 'error', 'info'

// Conectar a la base de datos
$pdo = connectDB(); // Esta función debería estar definida en ../db/conect.php

// 1. Cargar datos iniciales del usuario
$user = null;
$control_fisico = ['peso_kg' => '', 'altura_cm_cf' => '']; // Valores por defecto para control_fisico

try {
    $user = getUserData($pdo, $user_id); // Obtiene datos de la tabla 'usuarios'
    if (!$user) {
        $message = "Error: Usuario no encontrado.";
        $message_type = 'error';
        // En un caso real, esto podría indicar una sesión inválida y requerir logout.
        // header('Location: logout.php'); exit();
    }

    $latest_control = getLatestControlFisico($pdo, $user_id); // Obtiene el último registro de 'control_fisico'
    if ($latest_control) {
        $control_fisico['peso_kg'] = $latest_control['peso_kg'];
        $control_fisico['altura_cm_cf'] = $latest_control['altura_cm']; // Usamos un nombre diferente para evitar conflicto con user['altura_cm']
    }


} catch (Exception $e) {
    $message = "Error al cargar datos: " . $e->getMessage();
    $message_type = 'error';
    error_log("Error loading user profile data: " . $e->getMessage());
}

// 2. Procesar el formulario de actualización (si se envió por POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    // Datos de la tabla 'usuarios'
    $nombre = trim($_POST['nombre'] ?? '');
    $objetivo_salud = trim($_POST['objetivo_salud'] ?? '');
    $edad = isset($_POST['edad']) && is_numeric($_POST['edad']) ? (int)$_POST['edad'] : null;
    $sexo = $_POST['sexo'] ?? null;
    $altura_cm_user = isset($_POST['altura_cm_user']) && is_numeric($_POST['altura_cm_user']) ? (float)$_POST['altura_cm_user'] : null; // Altura de la tabla usuarios

    // Datos de la tabla 'control_fisico' (nuevo registro)
    $peso_kg_cf = isset($_POST['peso_kg_cf']) && is_numeric($_POST['peso_kg_cf']) ? (float)$_POST['peso_kg_cf'] : null; // Peso para nuevo registro de control_fisico
    $altura_cm_cf = isset($_POST['altura_cm_cf']) && is_numeric($_POST['altura_cm_cf']) ? (float)$_POST['altura_cm_cf'] : null; // Altura para nuevo registro de control_fisico

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    // Validaciones básicas de entrada
    if (empty($nombre)) {
        $message = "El nombre no puede estar vacío.";
        $message_type = 'error';
    } else if ($edad !== null && ($edad < 0 || $edad > 120)) {
        $message = "La edad debe ser un número válido entre 0 y 120.";
        $message_type = 'error';
    } else if ($altura_cm_user !== null && ($altura_cm_user < 50 || $altura_cm_user > 250)) {
        $message = "La altura debe ser un valor válido en cm (50-250).";
        $message_type = 'error';
    } else if ($peso_kg_cf !== null && ($peso_kg_cf < 0 || $peso_kg_cf > 600)) {
        $message = "El peso debe ser un número válido en kg (0-600).";
        $message_type = 'error';
    } else if ($altura_cm_cf !== null && ($altura_cm_cf < 50 || $altura_cm_cf > 250)) {
        $message = "La altura de control físico debe ser un valor válido en cm (50-250).";
        $message_type = 'error';
    }
    // Puedes añadir más validaciones aquí (ej. para sexo)

    if ($message_type !== 'error') { // Solo procede si no hay errores de validación inicial
        try {
            $changes_result = updateUserProfile(
                $pdo,
                $user_id,
                $nombre,
                $objetivo_salud,
                $edad,
                $sexo,
                $altura_cm_user,
                $peso_kg_cf, // Este es para control_fisico
                $altura_cm_cf, // Este es para control_fisico
                $current_password,
                $new_password,
                $confirm_new_password,
                $user['contraseña'] // Usar el nombre de columna correcto de la DB
            );

            if ($changes_result['status'] === 'success') {
                $message = $changes_result['message'];
                $message_type = 'success';
                // Recargar los datos del usuario después de una actualización exitosa
                $user = getUserData($pdo, $user_id);
                $latest_control = getLatestControlFisico($pdo, $user_id);
                if ($latest_control) {
                    $control_fisico['peso_kg'] = $latest_control['peso_kg'];
                    $control_fisico['altura_cm_cf'] = $latest_control['altura_cm'];
                } else {
                    $control_fisico = ['peso_kg' => '', 'altura_cm_cf' => ''];
                }

            } else {
                $message = $changes_result['message'];
                $message_type = 'error';
            }

        } catch (Exception $e) {
            $message = "Error inesperado al actualizar: " . $e->getMessage();
            $message_type = 'error';
            error_log("Error updating profile in perfil.php: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrintel - Mi Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/agenda.css"> <link rel="stylesheet" href="../styles/perfil.css"> </head>
<body>
    <header class="main-header">
        <div class="header-left">
            <h1 class="page-title">Nutrintel - Perfil de <?php echo htmlspecialchars($user['nombre'] ?? 'Usuario'); ?></h1>
        </div>
        <div class="header-right">
            <nav>
                <ul class="nav-links">
                    <li><a href="agenda.php">Inicio</a></li>
                    <li><a href="perfil.php">Perfil</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <section class="profile-section">
            <h2>Configuración del Perfil</h2>

            <?php if ($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form id="profileForm" method="POST" action="perfil.php">
                <fieldset>
                    <legend>Datos Personales</legend>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($user['correo'] ?? ''); ?>" disabled title="El correo no puede ser cambiado directamente aquí.">
                        <small>El correo no se puede cambiar desde esta sección.</small>
                    </div>
                    <div class="form-group">
                        <label for="edad">Edad:</label>
                        <input type="number" id="edad" name="edad" min="1" max="120" value="<?php echo htmlspecialchars($user['edad'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="sexo">Sexo:</label>
                        <select id="sexo" name="sexo">
                            <option value="">Selecciona</option>
                            <option value="masculino" <?php echo ($user['sexo'] ?? '') === 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                            <option value="femenino" <?php echo ($user['sexo'] ?? '') === 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                            <option value="otro" <?php echo ($user['sexo'] ?? '') === 'otro' ? 'selected' : ''; ?>>Otro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="altura_cm_user">Altura (cm):</label>
                        <input type="number" id="altura_cm_user" name="altura_cm_user" step="0.1" min="50" max="250" value="<?php echo htmlspecialchars($user['altura_cm'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="objetivo_salud">Objetivo de Salud:</label>
                        <textarea id="objetivo_salud" name="objetivo_salud" rows="3"><?php echo htmlspecialchars($user['objetivo_salud'] ?? ''); ?></textarea>
                        <small>Ej: "Ganar masa muscular y mejorar resistencia"</small>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Medidas Físicas Recientes</legend>
                    <p>Estas medidas registrarán un nuevo punto de control de tu progreso.</p>
                    <div class="form-group">
                        <label for="peso_kg_cf">Peso (kg):</label>
                        <input type="number" id="peso_kg_cf" name="peso_kg_cf" step="0.1" min="0" max="600" value="<?php echo htmlspecialchars($control_fisico['peso_kg'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="altura_cm_cf">Altura (cm - para control físico):</label>
                        <input type="number" id="altura_cm_cf" name="altura_cm_cf" step="0.1" min="50" max="250" value="<?php echo htmlspecialchars($control_fisico['altura_cm_cf'] ?? ''); ?>">
                        <small>Si tu altura ha cambiado, regístrala aquí. Esto creará un nuevo registro de control.</small>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Cambiar Contraseña</legend>
                    <div class="form-group">
                        <label for="current_password">Contraseña Actual:</label>
                        <input type="password" id="current_password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nueva Contraseña:</label>
                        <input type="password" id="new_password" name="new_password">
                        <small>Mínimo 8 caracteres.</small>
                    </div>
                    <div class="form-group">
                        <label for="confirm_new_password">Confirmar Nueva Contraseña:</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password">
                    </div>
                </fieldset>

                <button type="submit" class="submit-button">Guardar Cambios</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Nutrintel | Tu salud potenciada por la tecnología</p>
    </footer>

    </body>
</html>