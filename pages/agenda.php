<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrintel - Mi Agenda</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/agenda.css">
</head>
<body>
    <?php
        $usuario_id_simulado = 1;
        $nombre_usuario_simulado = "Juan Pérez";
        $objetivo_usuario_simulado = "Ganar masa muscular y mejorar resistencia";
        $recomendacion_ia_hoy_simulada = "Hoy concéntrate en proteínas magras y carbohidratos complejos para tu cena. Intenta añadir 30 minutos de entrenamiento de fuerza.";
    ?>

    <header class="main-header">
        <div class="header-left">
            <h1 class="page-title">Nutrintel - Agenda de <?php echo htmlspecialchars($nombre_usuario_simulado); ?></h1>
        </div>
        <div class="header-right">
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="#">Perfil</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-container">
        <section class="calendar-section">
            <div class="calendar-container">
                <div class="calendar-header">
                    <button id="prevMonth">&lt;</button>
                    <h2 id="currentMonthYear">Mes Año</h2>
                    <button id="nextMonth">&gt;</button>
                </div>
                <div class="calendar-weekdays">
                    <div>Lun</div>
                    <div>Mar</div>
                    <div>Mié</div>
                    <div>Jue</div>
                    <div>Vie</div>
                    <div>Sáb</div>
                    <div>Dom</div>
                </div>
                <div class="calendar-dates" id="calendarDates">
                    </div>
            </div>
        </section>

        <section class="info-section">
            <div class="info-container">
                <h3>Detalles del día: <span id="selectedDate"></span></h3>

                <div class="info-content">
                    <h4>✨ Recomendación IA para hoy</h4>
                    <p id="iaRecommendation">
                        <?php echo htmlspecialchars($recomendacion_ia_hoy_simulada); ?>
                    </p>
                </div>

                <div class="info-content">
                    <h4>🍽️ Tus comidas</h4>
                    <ul id="mealsList">
                        <li>Cargando comidas...</li>
                    </ul>
                    <button class="add-item-button" id="addMealBtn">Añadir Comida</button>
                </div>

                <div class="info-content">
                    <h4>💪 Tus ejercicios</h4>
                    <ul id="exercisesList">
                        <li>Cargando ejercicios...</li>
                    </ul>
                    <button class="add-item-button" id="addExerciseBtn">Añadir Ejercicio</button>
                </div>

                <button class="view-progress-button" id="viewProgressBtn">Ver Progreso</button>
            </div>
        </section>
    </main>

    <button class="fab-chat" id="openChatBtn">Consultar con IA</button>

    <div id="chatModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeChatBtn">&times;</span>
            <h4>💬 Chatea con Nutrintel IA</h4>
            <div class="chat-interface">
                <div id="chatMessages">
                    <p><strong>Nutrintel IA:</strong> ¡Hola! Soy tu asistente personal. Tu objetivo actual es **<?php echo htmlspecialchars($objetivo_usuario_simulado); ?>**. ¿En qué puedo ayudarte hoy?</p>
                </div>
                <input type="text" id="chatInput" placeholder="Escribe tu mensaje...">
                <button id="sendMessage">Enviar</button>
            </div>
        </div>
    </div>

    <div id="addMealModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeAddMealBtn">&times;</span>
            <h4>🍽️ Registrar Nueva Comida</h4>
            <form id="addMealForm">
                <label for="mealName">Nombre del Alimento:</label>
                <input type="text" id="mealName" name="mealName" required>

                <label for="mealQuantity">Cantidad (gramos):</label>
                <input type="number" id="mealQuantity" name="mealQuantity" min="1" required>

                <button type="submit" class="submit-button">Registrar Comida</button>
            </form>
        </div>
    </div>

    <div id="addExerciseModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeAddExerciseBtn">&times;</span>
            <h4>💪 Registrar Nuevo Ejercicio</h4>
            <form id="addExerciseForm">
                <label for="exerciseTitle">Título del Ejercicio:</label>
                <input type="text" id="exerciseTitle" name="exerciseTitle" required>

                <label for="exerciseDesc">Descripción (series, repeticiones, duración):</label>
                <textarea id="exerciseDesc" name="exerciseDesc" rows="3"></textarea>

                <button type="submit" class="submit-button">Registrar Ejercicio</button>
            </form>
        </div>
    </div>

    <div id="progressModal" class="modal">
        <div class="modal-content">
            <span class="close-button" id="closeProgressBtn">&times;</span>
            <h4>📊 Tu Progreso General</h4>
            <div id="progressContent">
                <p>Aquí verás gráficos y estadísticas de tu progreso a lo largo del tiempo.</p>
                <div class="progress-chart-placeholder">
                    <h5>Peso Corporal</h5>
                    <p>Gráfico de evolución de peso (simulado).</p>
                    </div>
                <div class="progress-chart-placeholder">
                    <h5>Calorías Consumidas (Promedio Semanal)</h5>
                    <p>Gráfico de ingesta calórica promedio (simulado).</p>
                </div>
                <div class="progress-chart-placeholder">
                    <h5>Actividad Física (Minutos Semanales)</h5>
                    <p>Gráfico de tiempo de ejercicio (simulado).</p>
                </div>
                <p>¡Sigue así para alcanzar tus metas!</p>
            </div>
        </div>
    </div>


    <footer>
        <p>&copy; 2025 Nutrintel | Tu salud potenciada por la tecnología</p>
    </footer>

    <script src="../scripts/agenda.js"></script>
    <script src="../scripts/addMealModal.js"></script>
    <script src="../scripts/addExerciseModal.js"></script>
</body>
</html>