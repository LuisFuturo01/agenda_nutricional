document.addEventListener('DOMContentLoaded', () => {
    const addExerciseModal = document.getElementById('addExerciseModal');
    const addExerciseBtn = document.getElementById('addExerciseBtn');
    const closeAddExerciseBtn = document.getElementById('closeAddExerciseBtn');
    const addExerciseForm = document.getElementById('addExerciseForm');

    addExerciseBtn.addEventListener('click', () => {
        addExerciseModal.style.display = 'flex';
    });

    closeAddExerciseBtn.addEventListener('click', () => {
        addExerciseModal.style.display = 'none';
        addExerciseForm.reset(); 
    });

    window.addEventListener('click', (event) => {
        if (event.target === addExerciseModal) {
            addExerciseModal.style.display = 'none';
            addExerciseForm.reset();
        }
    });

    addExerciseForm.addEventListener('submit', (e) => {
        e.preventDefault(); 

        const exerciseTitle = document.getElementById('exerciseTitle').value;
        const exerciseDesc = document.getElementById('exerciseDesc').value;

        let exerciseDate = `${window.currentYear}-${String(window.currentMonth + 1).padStart(2, '0')}-${String(window.selectedDay).padStart(2, '0')}`;

        // SIMULACIÓN: En un sistema real, aquí harías una petición AJAX (fetch/axios)
        // a un endpoint PHP (ej. 'api/add_exercise.php') para guardar en la DB.
        console.log('Enviando datos de ejercicio:', { exerciseTitle, exerciseDesc, exerciseDate });

        alert(`Ejercicio registrado (simulado): ${exerciseTitle}, el ${exerciseDate}`);

        addExerciseModal.style.display = 'none'; 
        addExerciseForm.reset();

        // Refrescar la lista de ejercicios para el día actual sin recargar la página
        window.fetchDataForDate(window.currentYear, window.currentMonth, window.selectedDay);
    });
});