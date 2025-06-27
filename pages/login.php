<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriWell - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="../styles/login.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo">🥗</div>
            <h1 class="app-name">NutriTell</h1>
            <p class="app-tagline">Tu vida saludable inicia aquí</p>
        </div>

        <form action="../db/login_usuario_be.php" method="POST" class="login-form" >
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    name="correo" 
                    class="form-input" 
                    placeholder="ejemplo@gmail.com"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    name="contrasena" 
                    class="form-input" 
                    placeholder="Ingresa tu contraseña"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Iniciar Sesión
            </button>

            <div class="forgot-password">
                <a href="#forgot">¿Olvidaste tu contraseña?</a>
            </div>
        </form>

        <div class="signup-link">
            <p>¿Aún no tienes una cuenta?</p>
            <a href="register.php">Create una cuenta</a>
        </div>
    </div>
</body>
</html>