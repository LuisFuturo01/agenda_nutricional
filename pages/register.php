<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriWell - Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/register.css">
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo">🥗</div>
            <h1 class="app-name">NutriTell</h1>
            <p class="app-tagline">Comienza tu viaje hacia el bienestar</p>
        </div>

        <form action="../db/registro_usuario_be.php" method="POST" class="register-form">
            <div class="form-section">
                <h2 class="section-title">Información Personal</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input 
                            type="text" 
                            name="nombre" 
                            class="form-input" 
                            placeholder="Ingresa tu nombre completo"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input 
                            type="email" 
                            name="correo" 
                            class="form-input" 
                            placeholder="ejemplo@correo.com"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input 
                            type="password" 
                            name="contrasena" 
                            class="form-input" 
                            placeholder="Crea una contraseña de 4 carácteres o mas"
                            required
                            minlength="4"
                        >
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">Datos Físicos</h2>
                <div class="form-grid">
                    <div class="form-row two-columns">
                        <div class="form-group">
                            <label for="edad" class="form-label">Edad</label>
                            <input 
                                type="number" 
                                name="edad" 
                                class="form-input" 
                                placeholder="Edad mínima 13 años"
                                required
                                min="13"
                                max="120"
                            >
                        </div>

                        <div class="form-group">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select 
                                id="sexo" 
                                name="sexo" 
                                class="form-select" 
                                required
                            >
                                <option value="">Selecciona una opción</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="altura" class="form-label">Altura</label>
                        <div class="input-suffix" data-suffix="cm">
                            <input 
                                type="number" 
                                name="altura_cm" 
                                class="form-input" 
                                placeholder="170"
                                required
                                min="100"
                                max="250"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fecha-registro" class="form-label">Fecha de Registro</label>
                        <input 
                            type="date" 
                            name="fecha_registro" 
                            class="form-input" 
                            required
                        >
                    </div>
                </div>
            </div>

            <button type="submit" class="register-button">
                Registrarse
            </button>
        </form>

        <div class="login-link">
            <p>¿Ya tienes una cuenta?</p>
            <a href="login.php">Inicia sesión aquí</a>
        </div>
    </div>
</body>
</html>