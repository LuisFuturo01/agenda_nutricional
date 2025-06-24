document.addEventListener('DOMContentLoaded', () => {
    const calendarDates = document.getElementById('calendarDates');
    const currentMonthYear = document.getElementById('currentMonthYear');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const selectedDateSpan = document.getElementById('selectedDate');
    const iaRecommendationElem = document.getElementById('iaRecommendation');
    const mealsList = document.getElementById('mealsList');
    const exercisesList = document.getElementById('exercisesList');

    // Chat Modal elements
    const chatModal = document.getElementById('chatModal');
    const openChatBtn = document.getElementById('openChatBtn');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
    const sendMessageBtn = document.getElementById('sendMessage');

    // Progress Modal elements
    const progressModal = document.getElementById('progressModal');
    const viewProgressBtn = document.getElementById('viewProgressBtn');
    const closeProgressBtn = document.getElementById('closeProgressBtn');

    // Hacemos estas variables globales para que los módulos de modales puedan acceder a ellas
    window.currentMonth = new Date().getMonth();
    window.currentYear = new Date().getFullYear();
    window.selectedDay = new Date().getDate(); // Initialize with current day
    let today = new Date(); // Internal to agenda.js for comparison with current day

    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

    // SIMULACIÓN: Variable para el objetivo del usuario (se modificaría en el chat)
    let currentUserObjective = "Ganar masa muscular y mejorar resistencia";

    // --- Funciones para manejar la visualización de datos en la agenda ---

    // Esta función se llamará cuando se seleccione un día o al cargar la página
    window.fetchDataForDate = function(year, month, day) {
        const dateObj = new Date(year, month, day);
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        selectedDateSpan.textContent = dateObj.toLocaleDateString('es-ES', options);

        const selectedDateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        let simulatedMeals = [];
        let simulatedExercises = [];
        let simulatedIaRecommendation = "Explora tu Nutrintel para más información. ¡Hoy es un buen día para empezar algo nuevo!";

        // --- SIMULACIÓN DE DATOS ESPECÍFICOS POR FECHA (si los hay) ---
        if (selectedDateString === '2025-06-23') { // Ejemplo: Datos específicos para hoy
            simulatedMeals = [
                "Desayuno: Avena con frutas y nueces (300 kcal)",
                "Almuerzo: Pechuga de pollo a la plancha con brócoli y arroz integral (500 kcal)",
                "Cena: Ensalada de salmón y aguacate (400 kcal)"
            ];
            simulatedExercises = [
                "Gimnasio: 1 hora de entrenamiento de fuerza",
                "Cardio: 30 minutos de trote"
            ];
            simulatedIaRecommendation = "Excelente balance hoy. ¡No olvides hidratarte y estirar bien después del ejercicio!";
        } else if (selectedDateString === '2025-06-24') {
            simulatedMeals = [
                "Desayuno: Tostadas integrales con huevo y palta (350 kcal)",
                "Almuerzo: Lentejas con verduras (450 kcal)"
            ];
            simulatedExercises = [
                "Yoga: 45 minutos de vinyasa flow"
            ];
            simulatedIaRecommendation = "Considera añadir un snack proteico a media tarde para mantener tu energía. ¡Mantente constante!";
        }
        // --- FIN SIMULACIÓN DE DATOS ESPECÍFICOS ---

        // --- LÓGICA DE RECOMENDACIONES DE LA IA (si no hay suficientes datos específicos) ---
        const currentMealsCount = simulatedMeals.length;
        const currentExercisesCount = simulatedExercises.length;

        // Recomendaciones de comida
        if (currentMealsCount < 2) {
            if (currentUserObjective.includes("masa muscular")) {
                simulatedMeals.push("Comida Sugerida por IA: Snack pre-entreno (plátano y almendras).");
                if (currentMealsCount < 1) simulatedMeals.push("Comida Sugerida por IA: Comida principal alta en proteínas (salmón y quinoa).");
            } else if (currentUserObjective.includes("perder peso")) {
                simulatedMeals.push("Comida Sugerida por IA: Snack bajo en calorías (fruta o vegetales).");
                if (currentMealsCount < 1) simulatedMeals.push("Comida Sugerida por IA: Comida principal con verduras abundantes y proteína magra.");
            } else { // Default / Mejorar resistencia
                simulatedMeals.push("Comida Sugerida por IA: Snack saludable (yogur y granola).");
                if (currentMealsCount < 1) simulatedMeals.push("Comida Sugerida por IA: Comida principal con carbohidratos complejos para energía.");
            }
        }
        // Asegurarse de que no haya duplicados si se empujó dos veces con la misma lógica
        simulatedMeals = [...new Set(simulatedMeals)];
        if (simulatedMeals.length < 2) { // Fallback to ensure at least 2
             if (simulatedMeals.length < 1) simulatedMeals.push("Comida Sugerida por IA: Desayuno equilibrado.");
             if (simulatedMeals.length < 2) simulatedMeals.push("Comida Sugerida por IA: Cena nutritiva.");
        }


        // Recomendaciones de ejercicio
        if (currentExercisesCount < 2) {
            if (currentUserObjective.includes("masa muscular")) {
                simulatedExercises.push("Ejercicio Sugerido por IA: Sesión de fuerza (ej. piernas/hombros).");
                if (currentExercisesCount < 1) simulatedExercises.push("Ejercicio Sugerido por IA: Estiramientos dinámicos o calentamiento.");
            } else if (currentUserObjective.includes("perder peso")) {
                simulatedExercises.push("Ejercicio Sugerido por IA: Cardio intervalado (HIIT).");
                if (currentExercisesCount < 1) simulatedExercises.push("Ejercicio Sugerido por IA: Caminata post-comida (20 min).");
            } else { // Default / Mejorar resistencia
                simulatedExercises.push("Ejercicio Sugerido por IA: Entrenamiento de resistencia (ciclismo/natación).");
                if (currentExercisesCount < 1) simulatedExercises.push("Ejercicio Sugerido por IA: Ejercicios de movilidad articular.");
            }
        }
        simulatedExercises = [...new Set(simulatedExercises)];
        if (simulatedExercises.length < 2) { // Fallback to ensure at least 2
            if (simulatedExercises.length < 1) simulatedExercises.push("Ejercicio Sugerido por IA: 30 min de actividad ligera.");
            if (simulatedExercises.length < 2) simulatedExercises.push("Ejercicio Sugerido por IA: Estiramientos o yoga.");
        }


        // Actualizar la recomendación IA general del día (si no fue específica)
        if (simulatedIaRecommendation === "Explora tu Nutrintel para más información. ¡Hoy es un buen día para empezar algo nuevo!") {
             if (selectedDateString === today.toISOString().slice(0, 10)) { // Si es hoy
                simulatedIaRecommendation = `Tu objetivo es "${currentUserObjective}". ¡Hoy es un excelente día para avanzar hacia él con estas sugerencias!`;
             } else {
                 simulatedIaRecommendation = `Las recomendaciones para este día se basan en tu objetivo actual de "${currentUserObjective}".`;
             }
        }


        // Update UI
        iaRecommendationElem.textContent = simulatedIaRecommendation;

        mealsList.innerHTML = '';
        simulatedMeals.forEach(meal => {
            const li = document.createElement('li');
            li.textContent = meal;
            mealsList.appendChild(li);
        });

        exercisesList.innerHTML = '';
        simulatedExercises.forEach(exercise => {
            const li = document.createElement('li');
            li.textContent = exercise;
            exercisesList.appendChild(li);
        });
    }

    // --- Lógica del Calendario ---
    function renderCalendar() {
        calendarDates.innerHTML = '';
        currentMonthYear.textContent = `${monthNames[window.currentMonth]} ${window.currentYear}`;

        const firstDayOfMonth = new Date(window.currentYear, window.currentMonth, 1).getDay();
        const daysInMonth = new Date(window.currentYear, window.currentMonth + 1, 0).getDate();

        const startDay = (firstDayOfMonth === 0) ? 6 : firstDayOfMonth - 1;

        for (let i = 0; i < startDay; i++) {
            const emptyDiv = document.createElement('div');
            emptyDiv.classList.add('empty-day');
            calendarDates.appendChild(emptyDiv);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement('div');
            dayDiv.textContent = day;
            dayDiv.dataset.day = day;

            if (day === today.getDate() && window.currentMonth === today.getMonth() && window.currentYear === today.getFullYear()) {
                dayDiv.classList.add('current-day');
                window.selectedDay = day; // Set selected day for today on load
            }

            dayDiv.addEventListener('click', () => {
                document.querySelectorAll('.calendar-dates div').forEach(div => {
                    div.classList.remove('current-day');
                });
                dayDiv.classList.add('current-day');
                window.selectedDay = day; // Update global selectedDay

                window.fetchDataForDate(window.currentYear, window.currentMonth, window.selectedDay);
            });
            calendarDates.appendChild(dayDiv);
        }
        window.fetchDataForDate(window.currentYear, window.currentMonth, window.selectedDay); // Initial fetch for selected day
    }

    // Navegación del calendario
    prevMonthBtn.addEventListener('click', () => {
        window.currentMonth--;
        if (window.currentMonth < 0) {
            window.currentMonth = 11;
            window.currentYear--;
        }
        renderCalendar();
    });

    nextMonthBtn.addEventListener('click', () => {
        window.currentMonth++;
        if (window.currentMonth > 11) {
            window.currentMonth = 0;
            window.currentYear++;
        }
        renderCalendar();
    });


    // --- Lógica del Chat Modal ---
    openChatBtn.addEventListener('click', () => {
        chatModal.style.display = 'flex';
        const initialAIMessage = document.querySelector('#chatMessages p strong');
        if (initialAIMessage && initialAIMessage.textContent.includes('Tu objetivo actual es')) {
            initialAIMessage.nextSibling.textContent = `Tu objetivo actual es **${currentUserObjective}**. ¿En qué puedo ayudarte hoy?`;
        } else {
             chatMessages.innerHTML = `<p><strong>Nutrintel IA:</strong> ¡Hola! Soy tu asistente personal. Tu objetivo actual es **${currentUserObjective}**. ¿En qué puedo ayudarte hoy? Aunque soy una IA, el tiempo actual es Lunes, Junio 23, 2025 8:56 PM.`;
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    closeChatBtn.addEventListener('click', () => {
        chatModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === chatModal) {
            chatModal.style.display = 'none';
        }
    });

    // Chat con IA (Simulado con lógica de cambio de objetivo)
    sendMessageBtn.addEventListener('click', () => {
        const userMessage = chatInput.value.trim();
        if (userMessage) {
            const userMsgElem = document.createElement('p');
            userMsgElem.innerHTML = `<strong>Tú:</strong> ${userMessage}`;
            chatMessages.appendChild(userMsgElem);
            chatInput.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;

            setTimeout(() => {
                const iaResponseElem = document.createElement('p');
                let iaResponse = "Lo siento, soy una IA en desarrollo y no puedo responder a eso ahora. Por favor, reformula tu pregunta.";

                const changeObjectiveKeywords = ["cambiar mi objetivo a", "mi nuevo objetivo es", "quiero enfocarme en", "mi objetivo ahora es", "cambiar objetivo a"];
                let objectiveChanged = false;
                for (const keyword of changeObjectiveKeywords) {
                    if (userMessage.toLowerCase().includes(keyword)) {
                        const newObjectiveCandidate = userMessage.toLowerCase().split(keyword)[1]?.trim();
                        if (newObjectiveCandidate && newObjectiveCandidate.length > 5) { // Simple validation
                            let newObjective = newObjectiveCandidate
                                                .replace(/por favor\.?$/, '')
                                                .replace(/\.$/, '')
                                                .trim();
                            newObjective = newObjective.charAt(0).toUpperCase() + newObjective.slice(1);

                            currentUserObjective = newObjective; // Update the simulated objective
                            iaResponse = `¡Entendido! Tu nuevo objetivo es **${currentUserObjective}**. He actualizado tus preferencias y mis futuras recomendaciones se adaptarán a esto. Las "codificación de datos" se aplicará a partir de hoy y en un rango de tiempo adecuado para ayudarte a alcanzarlo.`;
                            objectiveChanged = true;
                            renderCalendar(); // Re-render calendar to update daily recommendations based on new objective
                            break;
                        }
                    }
                }

                if (!objectiveChanged) {
                    if (userMessage.toLowerCase().includes("hola")) {
                        iaResponse = "¡Hola! ¿En qué puedo ayudarte con tu salud o alimentación?";
                    } else if (userMessage.toLowerCase().includes("receta")) {
                        iaResponse = "Claro, ¿qué tipo de receta buscas? ¿Algo con proteínas, bajo en carbohidratos, para desayuno?";
                    } else if (userMessage.toLowerCase().includes("ejercicio")) {
                        iaResponse = "Para ejercicios, ¿te interesa entrenamiento de fuerza, cardio, flexibilidad, o algo específico para una parte del cuerpo?";
                    } else if (userMessage.toLowerCase().includes("objetivo")) {
                        iaResponse = `Tu objetivo actual es "**${currentUserObjective}**". ¿Quieres ajustar algo o discutir cómo progresar?`;
                    } else if (userMessage.toLowerCase().includes("gracias")) {
                        iaResponse = "De nada, ¡estoy aquí para ayudarte! Si tienes más preguntas, no dudes en consultar.";
                    }
                }

                iaResponseElem.innerHTML = `<strong>Nutrintel IA:</strong> ${iaResponse}`;
                chatMessages.appendChild(iaResponseElem);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);
        }
    });

    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessageBtn.click();
        }
    });

    // --- Lógica del Modal de Progreso ---
    viewProgressBtn.addEventListener('click', () => {
        progressModal.style.display = 'flex';
        // Aquí podrías cargar datos de progreso reales o simularlos
        // const progressContent = document.getElementById('progressContent');
        // progressContent.innerHTML = 'Cargando gráficos de progreso...';
        // Simulación: setTimeout para mostrar que se "carga" algo
        // setTimeout(() => {
        //     progressContent.innerHTML = `
        //         <p>¡Aquí verás tus logros y estadísticas!</p>
        //         <div class="progress-chart-placeholder">
        //             <h5>Peso Corporal</h5>
        //             <p>Gráfico de evolución de peso (simulado).</p>
        //         </div>
        //         <div class="progress-chart-placeholder">
        //             <h5>Calorías Consumidas (Promedio Semanal)</h5>
        //             <p>Gráfico de ingesta calórica promedio (simulado).</p>
        //         </div>
        //         <div class="progress-chart-placeholder">
        //             <h5>Actividad Física (Minutos Semanales)</h5>
        //             <p>Gráfico de tiempo de ejercicio (simulado).</p>
        //         </div>
        //         <p>¡Sigue así para alcanzar tus metas!</p>
        //     `;
        // }, 500);
    });

    closeProgressBtn.addEventListener('click', () => {
        progressModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === progressModal) {
            progressModal.style.display = 'none';
        }
    });


    renderCalendar(); // Initial render
});